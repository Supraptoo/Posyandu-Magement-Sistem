<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Imunisasi;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function kunjungan(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $kunjungans = Kunjungan::with(['pasien', 'petugas'])
            ->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date])
            ->get();

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = PDF::loadView('admin.laporan.pdf.kunjungan', [
                'kunjungans' => $kunjungans,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            
            return $pdf->download('laporan-kunjungan-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.laporan.kunjungan', compact('kunjungans'));
    }

    public function imunisasi(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $imunisasis = Imunisasi::with(['kunjungan.pasien'])
            ->whereMonth('tanggal_imunisasi', $request->bulan)
            ->whereYear('tanggal_imunisasi', $request->tahun)
            ->get();

        return view('admin.laporan.imunisasi', compact('imunisasis'));
    }

    public function balita(Request $request)
    {
        $balitas = Balita::with(['kunjungans'])
            ->when($request->has('status'), function($query) use ($request) {
                if ($request->status == 'aktif') {
                    return $query->aktif();
                }
                return $query;
            })
            ->paginate(15);

        return view('admin.laporan.balita', compact('balitas'));
    }

    public function exportStatistik()
    {
        $stats = [
            'total_balita' => Balita::count(),
            'total_remaja' => Remaja::count(),
            'total_lansia' => Lansia::count(),
            'kunjungan_bulan_ini' => Kunjungan::whereMonth('tanggal_kunjungan', date('m'))
                ->whereYear('tanggal_kunjungan', date('Y'))->count(),
            'imunisasi_bulan_ini' => Imunisasi::whereMonth('tanggal_imunisasi', date('m'))
                ->whereYear('tanggal_imunisasi', date('Y'))->count(),
        ];

        $pdf = PDF::loadView('admin.laporan.pdf.statistik', ['stats' => $stats]);
        return $pdf->download('statistik-posyandu-' . date('Y-m-d') . '.pdf');
    }
}