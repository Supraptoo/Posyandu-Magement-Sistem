<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return redirect()->route('kader.laporan.balita');
    }

    // ========================================================
    // TAMPILAN PREVIEW DI WEB (Butuh variabel $data)
    // ========================================================
    public function balita(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        // Query data untuk preview
        $data = Pemeriksaan::where('kategori_pasien', 'balita')
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        foreach ($data as $row) {
            $row->nama_pasien = $this->getNamaPasien($row->pasien_id, 'balita');
            $row->jenis_kelamin = $this->getJkPasien($row->pasien_id, 'balita');
        }

        return view('kader.laporan.balita', compact('data', 'bulan', 'tahun'));
    }

    public function remaja(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        // Query data untuk preview
        $data = Pemeriksaan::where('kategori_pasien', 'remaja')
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        foreach ($data as $row) {
            $row->nama_pasien = $this->getNamaPasien($row->pasien_id, 'remaja');
            $row->jenis_kelamin = $this->getJkPasien($row->pasien_id, 'remaja');
        }

        return view('kader.laporan.remaja', compact('data', 'bulan', 'tahun'));
    }

    public function lansia(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        // Query data untuk preview
        $data = Pemeriksaan::where('kategori_pasien', 'lansia')
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        foreach ($data as $row) {
            $row->nama_pasien = $this->getNamaPasien($row->pasien_id, 'lansia');
            $row->jenis_kelamin = $this->getJkPasien($row->pasien_id, 'lansia');
        }

        return view('kader.laporan.lansia', compact('data', 'bulan', 'tahun'));
    }


    // ========================================================
    // FUNGSI UTAMA UNDUH PDF DIRECT (Menggunakan DomPDF)
    // ========================================================
    public function generate(Request $request, $type)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        if (!in_array($type, ['balita', 'remaja', 'lansia'])) {
            abort(404);
        }

        // Ambil data untuk di-inject ke file PDF
        $data = Pemeriksaan::where('kategori_pasien', $type)
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->orderBy('tanggal_periksa', 'asc')
            ->get();

        foreach ($data as $row) {
            $row->nama_pasien = $this->getNamaPasien($row->pasien_id, $type);
            $row->jenis_kelamin = $this->getJkPasien($row->pasien_id, $type);
        }

        // Panggil template tabel terpisah dari folder 'templates'
        $pdf = PDF::loadView('kader.laporan.templates.table-' . $type, compact('data', 'bulan', 'tahun'));
        
        // Atur ukuran kertas menjadi Landscape agar tabelnya muat memanjang
        $pdf->setPaper('A4', 'landscape'); 

        // Generate nama file otomatis
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $fileName = "Laporan_{$type}_Bantarkulon_{$namaBulan}_{$tahun}.pdf";

        // Kembalikan sebagai File Download
        return $pdf->download($fileName); 
    }

    // ========================================================
    // HELPERS / FUNGSI BANTUAN
    // ========================================================
    private function getNamaPasien($id, $kategori)
    {
        try {
            return match($kategori){
                'remaja' => Remaja::find($id)?->nama_lengkap ?? 'Unknown',
                'lansia' => Lansia::find($id)?->nama_lengkap ?? 'Unknown',
                default  => Balita::find($id)?->nama_lengkap ?? 'Unknown',
            };
        } catch(\Throwable $e) { return 'Unknown'; }
    }

    private function getJkPasien($id, $kategori)
    {
        try {
            return match($kategori){
                'remaja' => Remaja::find($id)?->jenis_kelamin ?? '-',
                'lansia' => Lansia::find($id)?->jenis_kelamin ?? '-',
                default  => Balita::find($id)?->jenis_kelamin ?? '-',
            };
        } catch(\Throwable $e) { return '-'; }
    }
}