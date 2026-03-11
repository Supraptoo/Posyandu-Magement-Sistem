<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pemeriksaan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Barryvdh\DomPDF\Facade\Pdf; // TAMBAHAN WAJIB

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan
     */
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $jenis = $request->get('jenis', 'semua');

        $periode = Carbon::create($tahun, $bulan, 1);

        $query = Pemeriksaan::with(['balita', 'remaja', 'lansia'])
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun);

        if ($jenis !== 'semua') {
            $query->where('kategori_pasien', $jenis);
        }

        $data = $query->get();

        $ringkasan = [
            'total'     => $data->count(),
            'balita'    => $data->where('kategori_pasien', 'balita')->count(),
            'remaja'    => $data->where('kategori_pasien', 'remaja')->count(),
            'lansia'    => $data->where('kategori_pasien', 'lansia')->count(),
            'verified'  => $data->where('status_verifikasi', 'verified')->count(),
            'pending'   => $data->where('status_verifikasi', 'pending')->count(),
            'stunting'  => $data->whereIn('status_gizi', ['stunting', 'buruk'])->count(),
            'obesitas'  => $data->whereIn('status_gizi', ['obesitas', 'lebih'])->count(),
            'hipertensi'=> $data->filter(function($p) {
                $td = intval(explode('/', $p->tekanan_darah ?? '0/0')[0]);
                return $td >= 140;
            })->count(),
        ];

        return view('bidan.laporan.index', compact('bulan', 'tahun', 'jenis', 'periode', 'ringkasan', 'data'));
    }

    /**
     * Generate & Download PDF Otomatis menggunakan DomPDF
     */
    public function cetak(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $jenis = $request->get('jenis', 'semua');

        $periode = Carbon::create($tahun, $bulan, 1);

        $query = Pemeriksaan::with(['balita', 'remaja', 'lansia', 'pemeriksa', 'verifikator'])
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->where('status_verifikasi', 'verified')
            ->latest('tanggal_periksa');

        if ($jenis !== 'semua') {
            $query->where('kategori_pasien', $jenis);
        }

        $pemeriksaans = $query->get();

        $stats = [
            'total'      => $pemeriksaans->count(),
            'balita'     => $pemeriksaans->where('kategori_pasien', 'balita')->count(),
            'remaja'     => $pemeriksaans->where('kategori_pasien', 'remaja')->count(),
            'lansia'     => $pemeriksaans->where('kategori_pasien', 'lansia')->count(),
            'normal'     => $pemeriksaans->where('status_gizi', 'baik')->count(),
            'stunting'   => $pemeriksaans->whereIn('status_gizi', ['stunting', 'buruk'])->count(),
            'obesitas'   => $pemeriksaans->whereIn('status_gizi', ['obesitas', 'lebih'])->count(),
            'hipertensi' => $pemeriksaans->filter(function($p) {
                $td = intval(explode('/', $p->tekanan_darah ?? '0/0')[0]);
                return $td >= 140;
            })->count(),
        ];

        $judulJenis = match($jenis) {
            'balita' => 'Balita',
            'remaja' => 'Remaja',
            'lansia' => 'Lansia',
            default  => 'Semua Kategori',
        };

        // 1. Eksekusi file cetak.blade.php menjadi format PDF
        $pdf = Pdf::loadView('bidan.laporan.cetak', compact(
            'pemeriksaans', 'stats', 'periode', 'jenis', 'judulJenis', 'bulan', 'tahun'
        ))->setPaper('a4', 'landscape'); // Format Kertas A4 Memanjang

        // 2. Penamaan file saat diunduh
        $namaFile = 'Laporan_Posyandu_' . str_replace(' ', '_', $judulJenis) . '_' . $periode->format('M_Y') . '.pdf';

        // 3. Paksa Download Langsung
        return $pdf->download($namaFile);
    }
}