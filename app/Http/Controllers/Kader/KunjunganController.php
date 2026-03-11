<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    /**
     * Menampilkan Buku Kehadiran (Read-Only)
     */
    public function index(Request $request)
    {
        $search   = $request->get('search', '');
        $kategori = $request->get('kategori', 'semua');

        // Mulai query dengan memanggil relasi yang dibutuhkan
        $query = Kunjungan::with(['pasien', 'petugas', 'pemeriksaan', 'imunisasis'])
                    ->latest('tanggal_kunjungan')
                    ->latest('created_at'); // Urutkan dari yang terbaru datang

        // 1. Filter Berdasarkan Kategori Tab
        if ($kategori !== 'semua') {
            $pasienType = match($kategori) {
                'remaja' => 'App\Models\Remaja',
                'lansia' => 'App\Models\Lansia',
                default  => 'App\Models\Balita',
            };
            $query->where('pasien_type', $pasienType);
        }

        // 2. Filter Berdasarkan Pencarian (Real-Time Search)
        if ($search) {
            $balitaIds = Balita::where('nama_lengkap', 'like', "%$search%")->pluck('id');
            $remajaIds = Remaja::where('nama_lengkap', 'like', "%$search%")->pluck('id');
            $lansiaIds = Lansia::where('nama_lengkap', 'like', "%$search%")->pluck('id');

            $query->where(function($q) use($balitaIds, $remajaIds, $lansiaIds) {
                $q->where(fn($q2) => $q2->where('pasien_type', 'App\Models\Balita')->whereIn('pasien_id', $balitaIds))
                  ->orWhere(fn($q2) => $q2->where('pasien_type', 'App\Models\Remaja')->whereIn('pasien_id', $remajaIds))
                  ->orWhere(fn($q2) => $q2->where('pasien_type', 'App\Models\Lansia')->whereIn('pasien_id', $lansiaIds));
            });
        }

        // Ambil data dengan pagination
        $kunjungans = $query->paginate(15)->withQueryString();

        return view('kader.kunjungan.index', compact('kunjungans', 'search', 'kategori'));
    }

    /**
     * Menampilkan Detail Nota Kedatangan
     */
    public function show($id)
    {
        $kunjungan = Kunjungan::with(['pasien', 'petugas', 'pemeriksaan', 'imunisasis'])->findOrFail($id);
        
        return view('kader.kunjungan.show', compact('kunjungan'));
    }

    /**
     * BLOKIR FUNGSI CRUD LAINNYA
     * Karena ini adalah Logbook Otomatis, Kader tidak boleh menambah/mengedit manual dari sini.
     */
    public function create()
    {
        return back()->with('error', 'Kunjungan baru akan otomatis tercatat saat Anda menginput Pemeriksaan.');
    }

    public function store(Request $request)
    {
        abort(403, 'Akses ditolak.');
    }

    public function edit($id)
    {
        return back()->with('error', 'Data kunjungan tidak bisa diedit. Silakan edit melalui menu Pemeriksaan.');
    }

    public function update(Request $request, $id)
    {
        abort(403, 'Akses ditolak.');
    }

    public function destroy($id)
    {
        return back()->with('error', 'Penghapusan kehadiran hanya bisa dilakukan dengan menghapus data Pemeriksaannya.');
    }
}