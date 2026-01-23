<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Kunjungan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pasien' => Balita::count() + Remaja::count() + Lansia::count(),
            'kunjungan_hari_ini' => Kunjungan::whereDate('tanggal_kunjungan', today())->count(),
            'kunjungan_bulan_ini' => Kunjungan::whereMonth('tanggal_kunjungan', date('m'))->count(),
            'pasien_baru_bulan_ini' => Balita::whereMonth('created_at', date('m'))->count() +
                                       Remaja::whereMonth('created_at', date('m'))->count() +
                                       Lansia::whereMonth('created_at', date('m'))->count(),

            // Prevent undefined keys in blade (keamanan)
            'pemeriksaan_hari_ini' => 0,
            'konsultasi_hari_ini'   => 0,
            'total_pemeriksaan'     => 0,
        ];

        // Data jadwal / kunjungan untuk ditampilkan pada tabel Jadwal Hari Ini
        $jadwalHariIni = Kunjungan::whereDate('tanggal_kunjungan', today())
            ->with(['pemeriksaan', 'pasien']) // include relasi yang kamu pakai di blade
            ->orderBy('created_at', 'desc')
            ->get();

        // Kalau kamu sebelumnya pakai $kunjunganTerbaru juga bisa tetap dikirim
        $kunjunganTerbaru = Kunjungan::with('pasien')
            ->latest()
            ->take(10)
            ->get();

        return view('bidan.dashboard', compact('stats', 'jadwalHariIni', 'kunjunganTerbaru'));
    }
}
