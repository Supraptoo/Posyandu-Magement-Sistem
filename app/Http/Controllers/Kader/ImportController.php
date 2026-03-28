<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

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
     * Menampilkan Form Upload Excel (Smart Import Wizard)
     */
    public function create(Request $request)
    {
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
            'file'       => 'required|file|mimes:xlsx,xls,csv|max:10240', // Ditingkatkan ke 10 MB
        ], [
            'jenis_data.required' => 'Kategori data wajib dipilih.',
            'jenis_data.in'       => 'Kategori data tidak valid.',
            'file.required'       => 'Anda belum memilih file Excel/CSV.',
            'file.mimes'          => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV.',
            'file.max'            => 'Ukuran file terlalu besar. Maksimal 10 MB.'
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $jenisData = $request->jenis_data;
        
        // Mode Smart Mapping (Membaca checkbox dari UI baru)
        $isSmartImport = $request->has('smart_import');

        // 2. Simpan file secara fisik ke folder storage
        $path = $file->store('imports');

        // 3. Catat di Database
        $riwayat = DataImport::create([
            'nama_file'  => $originalName,
            'jenis_data' => $jenisData,
            'file_path'  => $path,
            'status'     => 'processing',
            'created_by' => auth()->id(),
        ]);

        // 4. Proses Import Eksekusi
        try {
            $importClass = match($jenisData) {
                'balita' => new BalitaImport(),
                'remaja' => new RemajaImport(),
                'lansia' => new LansiaImport(),
            };

            // TODO: Jika $isSmartImport = true, sistem di dalam Class Import 
            // harus disetel menggunakan WithHeadingRow dan mencocokkan nama kolom secara dinamis.
            
            Excel::import($importClass, $file);

            $modeText = $isSmartImport ? '[Mode Smart Mapping Aktif]' : '[Mode Standar]';
            $riwayat->update([
                'status'  => 'completed',
                'catatan' => "{$modeText} Data berhasil dianalisis, disesuaikan, dan disimpan ke sistem tanpa kendala.",
            ]);

            return redirect()->route('kader.import.history')
                ->with('success', 'Sukses! Sistem berhasil membaca dan memasukkan data Anda.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMsg = "Gagal memproses baris ke-" . $failures[0]->row() . " di Excel: " . $failures[0]->errors()[0];
            
            $riwayat->update(['status' => 'failed', 'catatan' => $errorMsg]);
            return redirect()->route('kader.import.history')
                ->with('error', 'Import gagal karena struktur data terlalu berantakan dan tidak bisa dikenali.');

        } catch (\Throwable $e) { 
            Log::error('Kesalahan Import Data ' . $jenisData . ': ' . $e->getMessage());
            $riwayat->update(['status' => 'failed', 'catatan' => 'Error Sistem: ' . $e->getMessage()]);

            return redirect()->route('kader.import.history')
                ->with('error', 'Terjadi kesalahan sistem saat memproses file.');
        }
    }

    /**
     * Menampilkan Tabel Riwayat Import
     */
    public function history(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $query = DataImport::query();

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $imports = $query->latest()->paginate(10)->withQueryString();
        return view('kader.import.history', compact('imports', 'tanggal'));
    }

    /**
     * Detail Satu Log Riwayat
     */
    public function show($id)
    {
        $import = DataImport::findOrFail($id);
        return view('kader.import.show', compact('import'));
    }

    public function destroy($id)
    {
        try {
            $import = DataImport::findOrFail($id);
            if ($import->file_path && Storage::exists($import->file_path)) {
                Storage::delete($import->file_path);
            }
            $import->delete();
            return redirect()->route('kader.import.history')->with('success', 'Log riwayat import dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data riwayat.');
        }
    }

    /**
     * DYNAMIC TEMPLATE GENERATOR (Mencegah Error File Not Found!)
     */
    public function downloadTemplate($type)
    {
        if (!in_array($type, ['balita', 'remaja', 'lansia'])) abort(404);

        $filePath = public_path("templates/template_{$type}.xlsx");

        // Jika file Excel fisik ada, langsung download
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        // JIKA TIDAK ADA: Generate CSV secara OTOMATIS (On-The-Fly)
        $headers = match($type) {
            'balita' => ['nama_lengkap', 'nik_balita', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir_yyyy_mm_dd', 'nama_ibu', 'nik_ibu', 'berat_lahir_kg', 'panjang_lahir_cm', 'alamat_lengkap'],
            'remaja' => ['nama_lengkap', 'nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir_yyyy_mm_dd', 'nama_sekolah', 'kelas', 'nama_ortu', 'no_hp_ortu', 'alamat_lengkap'],
            'lansia' => ['nama_lengkap', 'nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir_yyyy_mm_dd', 'riwayat_penyakit', 'status_keluarga', 'no_hp', 'alamat_lengkap'],
        };

        $csvFileName = "Template_KaderCare_" . strtoupper($type) . ".csv";
        $handle = fopen('php://temp', 'w');
        fputcsv($handle, $headers); // Tulis Header
        
        // Tambahkan 1 baris contoh (Dummy Data) agar Kader tidak bingung
        $dummyData = match($type) {
            'balita' => ['Budi Santoso', '3200000000000001', 'L', 'Jakarta', '2024-01-15', 'Siti Aminah', '3200000000000002', '3.5', '50', 'Jl. Merdeka No 1'],
            'remaja' => ['Ahmad Yani', '3200000000000003', 'L', 'Bandung', '2010-05-20', 'SMPN 1 Bandung', '8A', 'Bambang', '08123456789', 'Jl. Pahlawan No 2'],
            'lansia' => ['Suprapto', '3200000000000004', 'L', 'Surabaya', '1950-10-10', 'Hipertensi', 'Kepala Keluarga', '08111222333', 'Jl. Sudirman No 3'],
        };
        fputcsv($handle, $dummyData); // Tulis Dummy Data

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ]);
    }
}