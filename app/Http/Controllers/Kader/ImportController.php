<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

// Memanggil Model Utama
use App\Models\DataImport; 

// Memanggil Class Import
use App\Imports\BalitaImport;
use App\Imports\RemajaImport;
use App\Imports\LansiaImport;

class ImportController extends Controller
{
    /**
     * Menampilkan Halaman Utama Menu Import
     */
    public function index()
    {
        return view('kader.import.index');
    }

    /**
     * Menampilkan Form Upload Excel
     */
    public function create(Request $request)
    {
        // Menangkap parameter 'type' dari URL jika user mengklik tombol spesifik
        $type = $request->get('type', '');
        return view('kader.import.create', compact('type'));
    }

    /**
     * PROSES UTAMA: Menerima, Menyimpan, dan Mengeksekusi File Excel
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Super Ketat
        $request->validate([
            'jenis_data' => 'required|in:balita,remaja,lansia',
            'file'       => 'required|file|mimes:xlsx,xls,csv|max:5120', // Maksimal 5 MB
        ], [
            'jenis_data.required' => 'Kategori data wajib dipilih.',
            'jenis_data.in'       => 'Kategori data tidak valid.',
            'file.required'       => 'Anda belum memilih file Excel/CSV.',
            'file.mimes'          => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV.',
            'file.max'            => 'Ukuran file terlalu besar. Maksimal 5 MB.'
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $jenisData = $request->jenis_data;

        // 2. Simpan file secara fisik ke folder storage/app/imports (Penting untuk jejak audit)
        $path = $file->store('imports');

        // 3. Catat di Database dengan status 'processing'
        $riwayat = DataImport::create([
            'nama_file'  => $originalName,
            'jenis_data' => $jenisData,
            'file_path'  => $path,
            'status'     => 'processing',
            'created_by' => auth()->id(), // Mencatat ID kader yang melakukan upload
        ]);

        // 4. Proses Import ke Database menggunakan Try-Catch
        try {
            // Tentukan Class Import yang akan digunakan
            $importClass = match($jenisData) {
                'balita' => new BalitaImport(),
                'remaja' => new RemajaImport(),
                'lansia' => new LansiaImport(),
            };

            // Eksekusi proses import
            Excel::import($importClass, $file);

            // Jika eksekusi selesai tanpa error, update status menjadi 'completed'
            $riwayat->update([
                'status'  => 'completed',
                'catatan' => 'Data berhasil diproses dan disimpan ke sistem tanpa kendala.',
            ]);

            return redirect()->route('kader.import.history')
                ->with('success', 'File Excel berhasil diunggah dan data telah diimport!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Menangkap error jika ada format data yang salah di dalam file Excel (misal: Tanggal salah format)
            $failures = $e->failures();
            $errorMsg = "Gagal memproses baris ke-" . $failures[0]->row() . " di Excel: " . $failures[0]->errors()[0];
            
            $riwayat->update([
                'status'  => 'failed', 
                'catatan' => $errorMsg
            ]);
            
            return redirect()->route('kader.import.history')
                ->with('error', 'Import gagal karena ada format data yang tidak sesuai di dalam Excel.');

        } catch (\Throwable $e) { 
            // Menangkap SEMUA JENIS ERROR FATAL (Mencegah status nyangkut di "proses mutar-mutar")
            Log::error('Kesalahan Import Data ' . $jenisData . ': ' . $e->getMessage());
            
            $riwayat->update([
                'status'  => 'failed', 
                'catatan' => 'Error Sistem: ' . $e->getMessage()
            ]);

            return redirect()->route('kader.import.history')
                ->with('error', 'Terjadi kesalahan sistem saat memproses file. Silakan cek detail di riwayat.');
        }
    }

    /**
     * Menampilkan Tabel Riwayat Import (Dengan Filter Tanggal & Pagination Sempurna)
     */
    public function history(Request $request)
    {
        // Secara default menampilkan data import hari ini.
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));

        // Membangun query
        $query = DataImport::query();

        // Jika user memilih tanggal, filter berdasarkan tanggal tersebut
        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        // Terapkan Pagination (10 data per halaman).
        // Fungsi withQueryString() SANGAT PENTING agar saat user klik "Page 2", parameter tanggal tidak hilang!
        $imports = $query->latest()->paginate(10)->withQueryString();

        return view('kader.import.history', compact('imports', 'tanggal'));
    }

    /**
     * Menampilkan Detail Satu Log Riwayat
     */
    public function show($id)
    {
        $import = DataImport::findOrFail($id);
        return view('kader.import.show', compact('import'));
    }

    /**
     * Menghapus Log Riwayat beserta File Fisiknya
     */
    public function destroy($id)
    {
        try {
            $import = DataImport::findOrFail($id);
            
            // Hapus file fisik dari folder storage agar server tidak penuh
            if ($import->file_path && Storage::exists($import->file_path)) {
                Storage::delete($import->file_path);
            }

            // Hapus log dari database
            $import->delete();

            return redirect()->route('kader.import.history')
                ->with('success', 'Log riwayat import dan file aslinya berhasil dihapus dari sistem.');

        } catch (\Exception $e) {
            Log::error('Gagal menghapus file import: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data riwayat: ' . $e->getMessage());
        }
    }

    /**
     * Fitur Download Template Excel Kosong
     */
    public function downloadTemplate($type)
    {
        // Pastikan tipenya hanya yang diizinkan
        if (!in_array($type, ['balita', 'remaja', 'lansia'])) {
            abort(404);
        }

        // Lokasi file template di folder public/templates/
        $filePath = public_path("templates/template_{$type}.xlsx");

        // Jika file belum ada di folder public/templates, kembalikan error dengan anggun
        if (!file_exists($filePath)) {
            return back()->with('error', 'Maaf, file template excel untuk kategori ' . strtoupper($type) . ' belum tersedia di server.');
        }

        return response()->download($filePath);
    }
}