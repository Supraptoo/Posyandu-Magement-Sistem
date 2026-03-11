<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $nikUser = $user->nik ?? ($user->profile->nik ?? null);

        $pasienIds = [];
        
        // Kumpulkan ID Pasien
        $remaja = \App\Models\Remaja::where('nik', $nikUser)->first();
        if ($remaja) $pasienIds[] = ['id' => $remaja->id, 'kategori' => 'remaja', 'nama' => $remaja->nama_lengkap];

        $lansia = \App\Models\Lansia::where('nik', $nikUser)->first();
        if ($lansia) $pasienIds[] = ['id' => $lansia->id, 'kategori' => 'lansia', 'nama' => $lansia->nama_lengkap];

        $balitas = \App\Models\Balita::where('nik_ibu', $nikUser)->orWhere('nik_ayah', $nikUser)->get();
        foreach($balitas as $balita) {
            $pasienIds[] = ['id' => $balita->id, 'kategori' => 'balita', 'nama' => $balita->nama_lengkap];
        }

        // INTEGRASI BIDAN: Ambil data dari tabel Pemeriksaan yang SUDAH DIVALIDASI Bidan
        $riwayat = Pemeriksaan::where('status_verifikasi', 'verified')
            ->where(function($query) use ($pasienIds) {
                foreach ($pasienIds as $pasien) {
                    $query->orWhere(function($q) use ($pasien) {
                        $q->where('pasien_id', $pasien['id'])
                          ->where('kategori_pasien', $pasien['kategori']);
                    });
                }
            })
            ->orderBy('tanggal_periksa', 'desc')
            ->paginate(10);

        // Inject nama ke collection
        $riwayat->getCollection()->transform(function ($item) use ($pasienIds) {
            $p = collect($pasienIds)->first(function($val) use ($item) {
                return $val['id'] == $item->pasien_id && $val['kategori'] == $item->kategori_pasien;
            });
            $item->pasien_nama = $p ? $p['nama'] : '-';
            return $item;
        });

        return view('user.riwayat.index', compact('riwayat'));
    }
}