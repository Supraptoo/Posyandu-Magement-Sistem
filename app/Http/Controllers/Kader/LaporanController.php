<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Kunjungan;
use App\Models\Imunisasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanBalitaExport;
use App\Exports\LaporanRemajaExport;
use App\Exports\LaporanLansiaExport;
use App\Exports\LaporanImunisasiExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('kader.laporan.index');
    }

    public function balita(Request $request)
    {
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        // Query yang lebih akurat untuk mendapatkan balita yang didaftarkan dalam periode
        // atau memiliki kunjungan dalam periode tersebut
        $balitas = Balita::with(['kunjungans' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
            }, 'kunjungans.pemeriksaan', 'kunjungans.imunisasis'])
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                      ->orWhereHas('kunjungans', function($q) use ($start_date, $end_date) {
                          $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
                      });
            })
            ->orderBy('nama_lengkap')
            ->get();
            
        return view('kader.laporan.balita', compact('balitas', 'start_date', 'end_date'));
    }

    public function remaja(Request $request)
    {
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $remajas = Remaja::with(['kunjungans' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
            }, 'kunjungans.pemeriksaan'])
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                      ->orWhereHas('kunjungans', function($q) use ($start_date, $end_date) {
                          $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
                      });
            })
            ->orderBy('nama_lengkap')
            ->get();
            
        return view('kader.laporan.remaja', compact('remajas', 'start_date', 'end_date'));
    }

    public function lansia(Request $request)
    {
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $lansias = Lansia::with(['kunjungans' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
            }, 'kunjungans.pemeriksaan'])
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                      ->orWhereHas('kunjungans', function($q) use ($start_date, $end_date) {
                          $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
                      });
            })
            ->orderBy('nama_lengkap')
            ->get();
            
        return view('kader.laporan.lansia', compact('lansias', 'start_date', 'end_date'));
    }

    public function imunisasi(Request $request)
    {
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $imunisasis = Imunisasi::with(['kunjungan.pasien'])
            ->whereBetween('tanggal_imunisasi', [$start_date, $end_date])
            ->orderBy('tanggal_imunisasi', 'desc')
            ->get()
            ->groupBy('jenis_imunisasi');
            
        return view('kader.laporan.imunisasi', compact('imunisasis', 'start_date', 'end_date'));
    }

    public function kunjungan(Request $request)
    {
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        $kunjungans = Kunjungan::with(['pasien', 'petugas.profile'])
            ->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        // Statistik yang lebih akurat
        $stats = [
            'total' => $kunjungans->count(),
            'balita' => $kunjungans->where('pasien_type', 'App\Models\Balita')->count(),
            'remaja' => $kunjungans->where('pasien_type', 'App\Models\Remaja')->count(),
            'lansia' => $kunjungans->where('pasien_type', 'App\Models\Lansia')->count(),
            'imunisasi' => $kunjungans->where('jenis_kunjungan', 'imunisasi')->count(),
            'pemeriksaan' => $kunjungans->where('jenis_kunjungan', 'pemeriksaan')->count(),
            'konsultasi' => $kunjungans->where('jenis_kunjungan', 'konsultasi')->count(),
        ];
        
        return view('kader.laporan.kunjungan', compact('kunjungans', 'stats', 'start_date', 'end_date'));
    }

    public function generate(Request $request, $type)
    {
        $start_date = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $format = $request->get('format', 'pdf');
        
        // Tambahkan ekstensi file berdasarkan format
        $extension = $format === 'excel' ? 'xlsx' : 'pdf';
        $filename = 'laporan-' . $type . '-' . now()->format('YmdHis') . '.' . $extension;
        
        switch ($type) {
            case 'balita':
                return $this->generateLaporanBalita($start_date, $end_date, $format, $filename);
            case 'remaja':
                return $this->generateLaporanRemaja($start_date, $end_date, $format, $filename);
            case 'lansia':
                return $this->generateLaporanLansia($start_date, $end_date, $format, $filename);
            case 'imunisasi':
                return $this->generateLaporanImunisasi($start_date, $end_date, $format, $filename);
            case 'kunjungan':
                return $this->generateLaporanKunjungan($start_date, $end_date, $format, $filename);
            default:
                return back()->with('error', 'Jenis laporan tidak valid');
        }
    }

    private function generateLaporanBalita($start_date, $end_date, $format, $filename)
    {
        $data = Balita::with(['kunjungans' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
            }, 'kunjungans.pemeriksaan', 'kunjungans.imunisasis'])
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                      ->orWhereHas('kunjungans', function($q) use ($start_date, $end_date) {
                          $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
                      });
            })
            ->orderBy('nama_lengkap')
            ->get();
            
        if ($format === 'excel') {
            return Excel::download(new LaporanBalitaExport($data, $start_date, $end_date), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
        
        $pdf = Pdf::loadView('kader.laporan.pdf.balita', [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tanggal_cetak' => now(),
        ]);
        
        return $pdf->download($filename);
    }

    private function generateLaporanRemaja($start_date, $end_date, $format, $filename)
    {
        $data = Remaja::with(['kunjungans' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
            }, 'kunjungans.pemeriksaan'])
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                      ->orWhereHas('kunjungans', function($q) use ($start_date, $end_date) {
                          $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
                      });
            })
            ->orderBy('nama_lengkap')
            ->get();
            
        if ($format === 'excel') {
            return Excel::download(new LaporanRemajaExport($data, $start_date, $end_date), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
        
        $pdf = Pdf::loadView('kader.laporan.pdf.remaja', [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tanggal_cetak' => now(),
        ]);
        
        return $pdf->download($filename);
    }

    private function generateLaporanLansia($start_date, $end_date, $format, $filename)
    {
        $data = Lansia::with(['kunjungans' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
            }, 'kunjungans.pemeriksaan'])
            ->where(function($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                      ->orWhereHas('kunjungans', function($q) use ($start_date, $end_date) {
                          $q->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
                      });
            })
            ->orderBy('nama_lengkap')
            ->get();
            
        if ($format === 'excel') {
            return Excel::download(new LaporanLansiaExport($data, $start_date, $end_date), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
        
        $pdf = Pdf::loadView('kader.laporan.pdf.lansia', [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tanggal_cetak' => now(),
        ]);
        
        return $pdf->download($filename);
    }

    private function generateLaporanImunisasi($start_date, $end_date, $format, $filename)
    {
        $data = Imunisasi::with(['kunjungan.pasien'])
            ->whereBetween('tanggal_imunisasi', [$start_date, $end_date])
            ->orderBy('tanggal_imunisasi', 'desc')
            ->get();
            
        if ($format === 'excel') {
            return Excel::download(new LaporanImunisasiExport($data, $start_date, $end_date), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
        
        $pdf = Pdf::loadView('kader.laporan.pdf.imunisasi', [
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tanggal_cetak' => now(),
        ]);
        
        return $pdf->download($filename);
    }

    private function generateLaporanKunjungan($start_date, $end_date, $format, $filename)
    {
        $kunjungans = Kunjungan::with(['pasien', 'petugas.profile'])
            ->whereBetween('tanggal_kunjungan', [$start_date, $end_date])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        $stats = [
            'total' => $kunjungans->count(),
            'balita' => $kunjungans->where('pasien_type', 'App\Models\Balita')->count(),
            'remaja' => $kunjungans->where('pasien_type', 'App\Models\Remaja')->count(),
            'lansia' => $kunjungans->where('pasien_type', 'App\Models\Lansia')->count(),
            'imunisasi' => $kunjungans->where('jenis_kunjungan', 'imunisasi')->count(),
            'pemeriksaan' => $kunjungans->where('jenis_kunjungan', 'pemeriksaan')->count(),
            'konsultasi' => $kunjungans->where('jenis_kunjungan', 'konsultasi')->count(),
        ];
        
        $pdf = Pdf::loadView('kader.laporan.pdf.kunjungan', [
            'kunjungans' => $kunjungans,
            'stats' => $stats,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tanggal_cetak' => now(),
        ]);
        
        return $pdf->download($filename);
    }

    public function download($filename)
    {
        $path = storage_path('app/public/laporan/' . $filename);
        
        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan');
        }
        
        return response()->download($path);
    }
}