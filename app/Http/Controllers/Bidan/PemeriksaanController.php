<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use App\Models\AnalisisPemeriksaanRemaja;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pemeriksaans = Pemeriksaan::with(['kunjungan.pasien'])
            ->where('pemeriksa_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('bidan.pemeriksaan.index', compact('pemeriksaans'));
    }

    public function create($kunjungan_id)
    {
        $kunjungan = Kunjungan::with(['pasien'])->findOrFail($kunjungan_id);
        return view('bidan.pemeriksaan.create', compact('kunjungan'));
    }

    public function store(Request $request, $kunjungan_id)
    {
        $kunjungan = Kunjungan::findOrFail($kunjungan_id);
        
        $request->validate([
            'tinggi_badan' => 'nullable|numeric|min:0',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'suhu_tubuh' => 'nullable|numeric',
            'tekanan_darah' => 'nullable|string',
            'denyut_nadi' => 'nullable|integer',
            'respirasi' => 'nullable|integer',
            'hemoglobin' => 'nullable|numeric',
            'gula_darah' => 'nullable|numeric',
            'keluhan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        // Hitung IMT jika ada tinggi dan berat
        $imt = null;
        if ($request->tinggi_badan && $request->berat_badan && $request->tinggi_badan > 0) {
            $tinggi_m = $request->tinggi_badan / 100;
            $imt = $request->berat_badan / ($tinggi_m * $tinggi_m);
        }

        // Tentukan kategori IMT
        $kategori_imt = null;
        if ($imt) {
            if ($imt < 18.5) {
                $kategori_imt = 'kurus';
            } elseif ($imt >= 18.5 && $imt <= 24.9) {
                $kategori_imt = 'normal';
            } elseif ($imt >= 25 && $imt <= 29.9) {
                $kategori_imt = 'gemuk';
            } else {
                $kategori_imt = 'obesitas';
            }
        }

        $pemeriksaan = Pemeriksaan::create([
            'kunjungan_id' => $kunjungan_id,
            'pemeriksa_id' => auth()->id(),
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'lingkar_kepala' => $request->lingkar_kepala,
            'lingkar_lengan' => $request->lingkar_lengan,
            'suhu_tubuh' => $request->suhu_tubuh,
            'tekanan_darah' => $request->tekanan_darah,
            'denyut_nadi' => $request->denyut_nadi,
            'respirasi' => $request->respirasi,
            'imt' => $imt,
            'kategori_imt' => $kategori_imt,
            'hemoglobin' => $request->hemoglobin,
            'gula_darah' => $request->gula_darah,
            'keluhan' => $request->keluhan,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'rekomendasi' => $request->rekomendasi,
        ]);

        // Jika pasien adalah remaja, buat analisis
        if ($kunjungan->pasien_type == 'App\Models\Remaja') {
            $this->createAnalisisRemaja($pemeriksaan, $kunjungan->pasien_id);
        }

        return redirect()->route('bidan.pemeriksaan.show', $pemeriksaan->id)
            ->with('success', 'Pemeriksaan berhasil disimpan');
    }

    public function show($id)
    {
        $pemeriksaan = Pemeriksaan::with(['kunjungan.pasien', 'pemeriksa.profile'])
            ->findOrFail($id);
            
        return view('bidan.pemeriksaan.show', compact('pemeriksaan'));
    }

    private function createAnalisisRemaja($pemeriksaan, $remaja_id)
    {
        $remaja = \App\Models\Remaja::find($remaja_id);
        if (!$remaja) return;

        $usia = $remaja->usia;
        $jenis_kelamin = $remaja->jenis_kelamin;

        // Analisis IMT
        $imt_kategori = $this->analisisIMT($pemeriksaan->imt, $usia, $jenis_kelamin);
        
        // Analisis Hemoglobin
        $hemoglobin_kategori = $this->analisisHemoglobin($pemeriksaan->hemoglobin, $jenis_kelamin);
        
        // Analisis LILA
        $lila_kategori = $this->analisisLILA($pemeriksaan->lingkar_lengan, $jenis_kelamin);
        
        // Analisis Gula Darah
        $gula_darah_kategori = $this->analisisGulaDarah($pemeriksaan->gula_darah);

        AnalisisPemeriksaanRemaja::create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'remaja_id' => $remaja_id,
            'usia_saat_periksa' => $usia,
            'jenis_kelamin' => $jenis_kelamin,
            'imt_nilai' => $pemeriksaan->imt,
            'imt_kategori' => $imt_kategori,
            'hemoglobin_nilai' => $pemeriksaan->hemoglobin,
            'hemoglobin_kategori' => $hemoglobin_kategori,
            'lila_nilai' => $pemeriksaan->lingkar_lengan,
            'lila_kategori' => $lila_kategori,
            'gula_darah_sewaktu_nilai' => $pemeriksaan->gula_darah,
            'gula_darah_kategori' => $gula_darah_kategori,
            'rekomendasi_umum' => $this->generateRekomendasiUmum($imt_kategori, $hemoglobin_kategori),
            'status' => $this->determineStatus([$imt_kategori, $hemoglobin_kategori, $gula_darah_kategori]),
        ]);
    }

    private function analisisIMT($imt, $usia, $jenis_kelamin)
    {
        if (!$imt) return 'tidak_terukur';
        
        // Standar IMT untuk remaja (contoh sederhana)
        if ($imt < 18.5) return 'kurus';
        if ($imt >= 18.5 && $imt <= 22.9) return 'normal';
        if ($imt >= 23 && $imt <= 24.9) return 'berisiko_kegemukan';
        if ($imt >= 25 && $imt <= 29.9) return 'gemuk';
        return 'obesitas';
    }

    private function analisisHemoglobin($hb, $jenis_kelamin)
    {
        if (!$hb) return 'tidak_terukur';
        
        if ($jenis_kelamin == 'L') {
            if ($hb < 13) return 'anemia';
            if ($hb >= 13 && $hb <= 17) return 'normal';
            return 'tinggi';
        } else {
            if ($hb < 12) return 'anemia';
            if ($hb >= 12 && $hb <= 15) return 'normal';
            return 'tinggi';
        }
    }

    private function analisisLILA($lila, $jenis_kelamin)
    {
        if (!$lila) return 'tidak_terukur';
        
        $standar = ($jenis_kelamin == 'L') ? 23.5 : 22.5;
        
        if ($lila < $standar) return 'kurang';
        return 'normal';
    }

    private function analisisGulaDarah($gula_darah)
    {
        if (!$gula_darah) return 'tidak_terukur';
        
        if ($gula_darah < 70) return 'hipoglikemi';
        if ($gula_darah >= 70 && $gula_darah <= 140) return 'normal';
        if ($gula_darah > 140 && $gula_darah <= 200) return 'pra_diabetes';
        return 'diabetes';
    }

    private function generateRekomendasiUmum($imt_kategori, $hemoglobin_kategori)
    {
        $rekomendasi = [];
        
        if ($imt_kategori == 'kurus') {
            $rekomendasi[] = 'Tingkatkan asupan kalori dengan makanan bergizi seimbang';
        } elseif ($imt_kategori == 'gemuk' || $imt_kategori == 'obesitas') {
            $rekomendasi[] = 'Kurangi asupan kalori dan tingkatkan aktivitas fisik';
        }
        
        if ($hemoglobin_kategori == 'anemia') {
            $rekomendasi[] = 'Konsumsi makanan kaya zat besi seperti daging merah, sayuran hijau';
        }
        
        return implode('. ', $rekomendasi) ?: 'Kondisi normal, pertahankan pola hidup sehat';
    }

    private function determineStatus($kategori_array)
    {
        if (in_array('obesitas', $kategori_array) || in_array('diabetes', $kategori_array)) {
            return 'critical';
        }
        
        if (in_array('gemuk', $kategori_array) || in_array('pra_diabetes', $kategori_array) || in_array('anemia', $kategori_array)) {
            return 'warning';
        }
        
        if (in_array('kurus', $kategori_array) || in_array('hipoglikemi', $kategori_array)) {
            return 'danger';
        }
        
        return 'normal';
    }
}