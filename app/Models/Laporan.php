<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Imunisasi;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan library dompdf sudah diinstall

class LaporanController extends Controller
{
    // Halaman Utama Laporan
    public function index()
    {
        return view('kader.laporan.index');
    }

    // 1. Laporan Balita
    public function balita(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));

        // Ambil data balita (bisa difilter berdasarkan tanggal daftar atau kunjungan terakhir)
        // Di sini kita ambil semua balita aktif untuk laporan master data
        $balitas = Balita::with(['kunjungans' => function($q) use ($start_date, $end_date) {
                $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
                  ->latest();
            }, 'kunjungans.pemeriksaan'])
            ->get();

        return view('kader.laporan.balita', compact('balitas', 'start_date', 'end_date'));
    }

    // 2. Laporan Remaja
    public function remaja(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));

        $remajas = Remaja::with(['kunjungans' => function($q) use ($start_date, $end_date) {
                $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
                  ->latest();
            }, 'kunjungans.pemeriksaan'])
            ->get();

        return view('kader.laporan.remaja', compact('remajas', 'start_date', 'end_date'));
    }

    // 3. Laporan Lansia
    public function lansia(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));

        $lansias = Lansia::with(['kunjungans' => function($q) use ($start_date, $end_date) {
                $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
                  ->latest();
            }, 'kunjungans.pemeriksaan'])
            ->get();

        return view('kader.laporan.lansia', compact('lansias', 'start_date', 'end_date'));
    }

    // 4. Laporan Imunisasi
    public function imunisasi(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));

        // Ambil data imunisasi dalam range tanggal dan Grouping berdasarkan jenis
        $imunisasis = Imunisasi::with(['kunjungan.pasien'])
            ->whereBetween('tanggal_imunisasi', [$start_date, $end_date])
            ->get()
            ->groupBy('jenis_imunisasi'); // Penting: Sesuai blade view

        return view('kader.laporan.imunisasi', compact('imunisasis', 'start_date', 'end_date'));
    }

    // 5. Laporan Kunjungan
    public function kunjungan(Request $request)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));

        $kunjungans = Kunjungan::with(['pasien', 'petugas.profile'])
            ->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
            ->latest()
            ->get();

        // Hitung Statistik untuk Chart
        $stats = [
            'total' => $kunjungans->count(),
            'balita' => $kunjungans->where('pasien_type', 'App\Models\Balita')->count(),
            'remaja' => $kunjungans->where('pasien_type', 'App\Models\Remaja')->count(),
            'lansia' => $kunjungans->where('pasien_type', 'App\Models\Lansia')->count(),
            'pemeriksaan' => $kunjungans->where('jenis_kunjungan', 'pemeriksaan')->count(),
            'imunisasi' => $kunjungans->where('jenis_kunjungan', 'imunisasi')->count(),
            'konsultasi' => $kunjungans->where('jenis_kunjungan', 'konsultasi')->count(),
        ];

        return view('kader.laporan.kunjungan', compact('kunjungans', 'stats', 'start_date', 'end_date'));
    }

    // 6. Fungsi Generate / Export (PDF & Excel)
    public function generate(Request $request, $type)
    {
        $start_date = $request->get('start_date', date('Y-m-01'));
        $end_date = $request->get('end_date', date('Y-m-d'));
        $format = $request->get('format', 'pdf');

        $data = [];
        $view = '';
        $filename = 'Laporan_' . ucfirst($type) . '_' . date('Ymd_His');

        // Siapkan Data Berdasarkan Tipe
        switch ($type) {
            case 'balita':
                $data['balitas'] = Balita::with(['kunjungans' => function($q) use ($start_date, $end_date) {
                        $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date])->latest();
                    }, 'kunjungans.pemeriksaan'])->get();
                $view = 'kader.laporan.balita'; // Gunakan view yang sama, nanti di-tweak CSS-nya untuk PDF
                break;

            case 'remaja':
                $data['remajas'] = Remaja::with(['kunjungans' => function($q) use ($start_date, $end_date) {
                        $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date])->latest();
                    }, 'kunjungans.pemeriksaan'])->get();
                $view = 'kader.laporan.remaja';
                break;

            case 'lansia':
                $data['lansias'] = Lansia::with(['kunjungans' => function($q) use ($start_date, $end_date) {
                        $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date])->latest();
                    }, 'kunjungans.pemeriksaan'])->get();
                $view = 'kader.laporan.lansia';
                break;

            case 'imunisasi':
                $data['imunisasis'] = Imunisasi::with(['kunjungan.pasien'])
                    ->whereBetween('tanggal_imunisasi', [$start_date, $end_date])
                    ->get()
                    ->groupBy('jenis_imunisasi');
                $view = 'kader.laporan.imunisasi';
                break;

            case 'kunjungan':
                $kunjungans = Kunjungan::with(['pasien', 'petugas.profile'])
                    ->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
                    ->latest()
                    ->get();
                
                $data['kunjungans'] = $kunjungans;
                $data['stats'] = [
                    'total' => $kunjungans->count(),
                    'balita' => $kunjungans->where('pasien_type', 'App\Models\Balita')->count(),
                    'remaja' => $kunjungans->where('pasien_type', 'App\Models\Remaja')->count(),
                    'lansia' => $kunjungans->where('pasien_type', 'App\Models\Lansia')->count(),
                    'pemeriksaan' => $kunjungans->where('jenis_kunjungan', 'pemeriksaan')->count(),
                    'imunisasi' => $kunjungans->where('jenis_kunjungan', 'imunisasi')->count(),
                    'konsultasi' => $kunjungans->where('jenis_kunjungan', 'konsultasi')->count(),
                ];
                $view = 'kader.laporan.kunjungan';
                break;
        }

        // Tambahkan variabel tanggal ke data view
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['is_print'] = true; // Flag untuk view agar menyembunyikan tombol saat dicetak

        if ($format === 'pdf') {
            // Generate PDF menggunakan DomPDF
            $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        } else {
            // Export Excel Sederhana (Header Method)
            // Ini cara cepat tanpa library Maatwebsite, render table HTML ke Excel
            return response()->streamDownload(function() use ($view, $data) {
                echo view($view, $data);
            }, $filename . '.xls', [
                "Content-Type" => "application/vnd.ms-excel",
                "Content-Disposition" => "attachment; filename=\"$filename.xls\""
            ]);
        }
    }
}