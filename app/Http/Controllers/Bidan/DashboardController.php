<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

// Panggil Model yang dibutuhkan
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Pemeriksaan;
use App\Models\JadwalPosyandu;

class DashboardController extends Controller
{
    /**
     * Menampilkan Halaman Dashboard Bidan
     */
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. STATISTIK KARTU ATAS
        $totalBalita = Balita::count();
        $totalLansia = Lansia::count();
        
        // Asumsi 'status_gizi' balita disimpan di tabel Pemeriksaan atau Balita
        // Ini contoh query jika disimpan di tabel Pemeriksaan terbaru
        $balitaStunting = Pemeriksaan::where('kategori_pasien', 'balita')
                            ->whereIn('status_gizi', ['Stunting', 'Buruk', 'Kurang'])
                            ->distinct('pasien_id')
                            ->count();

        // Asumsi mencari Lansia dengan Hipertensi (Tekanan Darah tinggi, misal 140/90 ke atas)
        // Jika Anda punya kolom 'diagnosa' atau 'tekanan_darah'
        $lansiaHipertensi = Pemeriksaan::where('kategori_pasien', 'lansia')
                            ->where(function($q) {
                                $q->where('diagnosa', 'LIKE', '%hipertensi%')
                                  ->orWhere('diagnosa', 'LIKE', '%darah tinggi%');
                            })
                            ->distinct('pasien_id')
                            ->count();

        // Hitung antrian dari kader yang belum didiagnosa bidan (kolom diagnosa kosong)
        $jumlahBelumValidasi = Pemeriksaan::whereMonth('created_at', $bulanIni)
                                ->where(function($q) {
                                    $q->whereNull('diagnosa')
                                      ->orWhere('diagnosa', '');
                                })
                                ->count();

        // Cari Jadwal Posyandu terdekat (hari ini atau ke depan)
        $jadwalBerikutnya = JadwalPosyandu::whereDate('tanggal', '>=', Carbon::today())
                                ->orderBy('tanggal', 'asc')
                                ->first();


        // 2. DATA UNTUK TABEL ANTRIAN VALIDASI (Limit 5 data terbaru)
        $antrianPemeriksaan = Pemeriksaan::where(function($q) {
                                    $q->whereNull('diagnosa')
                                      ->orWhere('diagnosa', '');
                                })
                                ->latest()
                                ->take(5)
                                ->get();


        // 3. DATA PASIEN RISIKO TINGGI (Tabel Bawah)
        $pasienBerisiko = Pemeriksaan::whereNotNull('diagnosa')
                                ->where(function($q) {
                                    $q->where('diagnosa', 'LIKE', '%stunting%')
                                      ->orWhere('diagnosa', 'LIKE', '%buruk%')
                                      ->orWhere('diagnosa', 'LIKE', '%hipertensi%')
                                      ->orWhere('diagnosa', 'LIKE', '%anemia%')
                                      ->orWhere('diagnosa', 'LIKE', '%kritis%');
                                })
                                ->latest()
                                ->take(5)
                                ->get();


        // 4. DATA GRAFIK DONUT (Status Gizi Balita)
        $chartGizi = [
            'normal'   => Pemeriksaan::where('kategori_pasien', 'balita')->where('status_gizi', 'Normal')->count(),
            'kurang'   => Pemeriksaan::where('kategori_pasien', 'balita')->whereIn('status_gizi', ['Kurang', 'Gizi Kurang'])->count(),
            'stunting' => Pemeriksaan::where('kategori_pasien', 'balita')->whereIn('status_gizi', ['Stunting', 'Gizi Buruk', 'Buruk'])->count(),
            'lebih'    => Pemeriksaan::where('kategori_pasien', 'balita')->whereIn('status_gizi', ['Lebih', 'Obesitas'])->count(),
        ];


        // 5. DATA GRAFIK LINE (Tren Kunjungan 6 Bulan Terakhir)
        $labelBulan = [];
        $dataKunjungan = [];
        
        // Loop mundur dari 5 bulan lalu sampai bulan ini
        for ($i = 5; $i >= 0; $i--) {
            $bulanTarget = Carbon::now()->subMonths($i);
            // Format label menjadi singkat, misal "Okt", "Nov"
            $labelBulan[] = $bulanTarget->translatedFormat('M'); 
            
            // Hitung total pemeriksaan pada bulan & tahun tersebut
            $total = Pemeriksaan::whereMonth('created_at', $bulanTarget->month)
                                ->whereYear('created_at', $bulanTarget->year)
                                ->count();
                                
            $dataKunjungan[] = $total;
        }


        // 6. KIRIM SEMUA DATA KE VIEW
        return view('bidan.dashboard', compact(
            'totalBalita',
            'totalLansia',
            'balitaStunting',
            'lansiaHipertensi',
            'jumlahBelumValidasi',
            'jadwalBerikutnya',
            'antrianPemeriksaan',
            'pasienBerisiko',
            'chartGizi',
            'labelBulan',
            'dataKunjungan'
        ));
    }
}