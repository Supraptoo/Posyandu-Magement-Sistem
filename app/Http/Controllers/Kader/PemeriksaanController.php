<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type', 'all');
        
        $pemeriksaans = Pemeriksaan::with(['kunjungan.pasien', 'pemeriksa.profile'])
            ->when($search, function($query) use ($search) {
                return $query->whereHas('kunjungan.pasien', function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                });
            })
            ->when($type !== 'all', function($query) use ($type) {
                return $query->whereHas('kunjungan', function($q) use ($type) {
                    $modelClass = $this->getModelClass($type);
                    $q->where('pasien_type', $modelClass);
                });
            })
            ->latest()
            ->paginate(15);
            
        return view('kader.pemeriksaan.index', compact('pemeriksaans', 'search', 'type'));
    }

    public function create(Request $request)
    {
        // Jika diakses dari tombol "Tambah Kunjungan" di detail pasien
        $pasien_id = $request->get('pasien_id');
        $pasien_type = $request->get('pasien_type'); // 'balita', 'remaja', 'lansia'
        
        $pasien = null;
        if ($pasien_id && $pasien_type) {
            try {
                $modelClass = $this->getModelClass($pasien_type);
                $pasien = $modelClass::find($pasien_id);
            } catch (\Exception $e) {
                // Ignore error, form will just be empty
            }
        }
        
        // Load data untuk dropdown select (Optimasi Query)
        $balitas = Balita::select('id', 'nama_lengkap', 'nik', 'tanggal_lahir')->orderBy('nama_lengkap')->get();
        $remajas = Remaja::select('id', 'nama_lengkap', 'nik', 'tanggal_lahir')->orderBy('nama_lengkap')->get();
        $lansias = Lansia::select('id', 'nama_lengkap', 'nik', 'tanggal_lahir')->orderBy('nama_lengkap')->get();
        
        return view('kader.pemeriksaan.create', compact('pasien', 'pasien_type', 'balitas', 'remajas', 'lansias'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Awal (Hanya untuk memastikan Kunjungan bisa dibuat)
        $request->validate([
            'pasien_type' => 'required|in:balita,remaja,lansia',
            'pasien_id' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'jenis_kunjungan' => 'required|in:pemeriksaan,konsultasi,imunisasi,umum',
        ]);

        try {
            // 2. Buat Data Kunjungan
            $countToday = Kunjungan::whereDate('created_at', today())->count();
            $kode_kunjungan = 'KJ-' . date('Ymd') . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
            $modelClass = $this->getModelClass($request->pasien_type); // Convert 'balita' -> 'App\Models\Balita'
            
            $kunjungan = Kunjungan::create([
                'kode_kunjungan' => $kode_kunjungan,
                'pasien_id' => $request->pasien_id,
                'pasien_type' => $modelClass,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jenis_kunjungan' => $request->jenis_kunjungan,
                'keluhan' => $request->keluhan,
                'petugas_id' => Auth::id(),
            ]);
            
            // 3. Validasi Data Fisik (Sesuai Jenis Pasien)
            $validationRules = $this->getValidationRules($request->pasien_type);
            $pemeriksaanData = $request->validate($validationRules);
            
            // 4. Hitung IMT Otomatis (Jika berat & tinggi diisi)
            if (!empty($pemeriksaanData['tinggi_badan']) && !empty($pemeriksaanData['berat_badan']) && $pemeriksaanData['tinggi_badan'] > 0) {
                $tinggi_m = $pemeriksaanData['tinggi_badan'] / 100;
                $pemeriksaanData['imt'] = $pemeriksaanData['berat_badan'] / ($tinggi_m * $tinggi_m);
                $pemeriksaanData['kategori_imt'] = $this->getKategoriIMT($pemeriksaanData['imt']);
            }
            
            // 5. Simpan Pemeriksaan
            $pemeriksaanData['kunjungan_id'] = $kunjungan->id;
            $pemeriksaanData['pemeriksa_id'] = Auth::id();
            
            $pemeriksaan = Pemeriksaan::create($pemeriksaanData);
            
            return redirect()->route('kader.pemeriksaan.show', $pemeriksaan->id)
                ->with('success', 'Pemeriksaan berhasil disimpan');
                
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pemeriksaan = Pemeriksaan::with(['kunjungan.pasien', 'pemeriksa.profile'])->findOrFail($id);
        return view('kader.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function edit($id)
    {
        $pemeriksaan = Pemeriksaan::with(['kunjungan.pasien'])->findOrFail($id);
        
        // Ubah Model Class (App\Models\Balita) menjadi string pendek ('balita') untuk View
        $pasien_type = $this->getTypeFromModel($pemeriksaan->kunjungan->pasien_type);
        
        return view('kader.pemeriksaan.edit', compact('pemeriksaan', 'pasien_type'));
    }

    public function update(Request $request, $id)
    {
        $pemeriksaan = Pemeriksaan::with(['kunjungan'])->findOrFail($id);
        
        // Dapatkan tipe pasien dari data kunjungan yang sudah ada
        $pasien_type = $this->getTypeFromModel($pemeriksaan->kunjungan->pasien_type);
        
        // Validasi sesuai tipe pasien tersebut
        $validationRules = $this->getValidationRules($pasien_type);
        $pemeriksaanData = $request->validate($validationRules);
        
        // Hitung ulang IMT
        if (!empty($pemeriksaanData['tinggi_badan']) && !empty($pemeriksaanData['berat_badan']) && $pemeriksaanData['tinggi_badan'] > 0) {
            $tinggi_m = $pemeriksaanData['tinggi_badan'] / 100;
            $pemeriksaanData['imt'] = $pemeriksaanData['berat_badan'] / ($tinggi_m * $tinggi_m);
            $pemeriksaanData['kategori_imt'] = $this->getKategoriIMT($pemeriksaanData['imt']);
        }
        
        $pemeriksaan->update($pemeriksaanData);
        
        // Update data kunjungan (keluhan/tanggal) jika ada perubahan
        $pemeriksaan->kunjungan->update([
            'keluhan' => $request->keluhan,
            'jenis_kunjungan' => $request->jenis_kunjungan ?? $pemeriksaan->kunjungan->jenis_kunjungan,
        ]);
        
        return redirect()->route('kader.pemeriksaan.show', $id)
            ->with('success', 'Pemeriksaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        // Hapus kunjungan juga (Cascade delete akan menghapus pemeriksaan, tapi kita manual saja agar aman)
        $pemeriksaan->kunjungan->delete(); 
        
        return redirect()->route('kader.pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil dihapus');
    }

    /* ================= HELPER METHODS ================= */

    private function getModelClass($type)
    {
        return match($type) {
            'balita' => 'App\Models\Balita',
            'remaja' => 'App\Models\Remaja',
            'lansia' => 'App\Models\Lansia',
            default => throw new \Exception('Jenis pasien tidak valid'),
        };
    }

    private function getTypeFromModel($modelClass)
    {
        return match($modelClass) {
            'App\Models\Balita' => 'balita',
            'App\Models\Remaja' => 'remaja',
            'App\Models\Lansia' => 'lansia',
            default => 'umum',
        };
    }

    // Rule Validasi Dinamis Sesuai Jenis Pasien
    private function getValidationRules($type)
    {
        $commonRules = [
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ];
        
        $specificRules = match($type) {
            'balita' => [
                'berat_badan' => 'required|numeric|min:0',
                'tinggi_badan' => 'required|numeric|min:0',
                'lingkar_kepala' => 'nullable|numeric',
                'lingkar_lengan' => 'nullable|numeric',
                'suhu_tubuh' => 'nullable|numeric',
            ],
            'remaja' => [
                'berat_badan' => 'required|numeric',
                'tinggi_badan' => 'required|numeric',
                'tekanan_darah' => 'nullable|string', // Penting untuk remaja
                'hemoglobin' => 'nullable|numeric',   // Cek Anemia
                'lingkar_lengan' => 'nullable|numeric',
            ],
            'lansia' => [
                'berat_badan' => 'required|numeric',
                'tinggi_badan' => 'required|numeric',
                'tekanan_darah' => 'required|string', // Wajib untuk lansia
                'gula_darah' => 'nullable|numeric',
                'kolesterol' => 'nullable|numeric',
                'asam_urat' => 'nullable|numeric',
            ],
            default => []
        };
        
        return array_merge($commonRules, $specificRules);
    }

    private function getKategoriIMT($imt)
    {
        if ($imt < 18.5) return 'kurus';
        if ($imt >= 18.5 && $imt <= 24.9) return 'normal';
        if ($imt >= 25 && $imt <= 29.9) return 'gemuk';
        return 'obesitas';
    }
}