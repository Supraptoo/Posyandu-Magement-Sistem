<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Remaja;
use App\Models\Pemeriksaan;
use App\Models\KonselingRemaja;
use Illuminate\Support\Facades\Auth;

class RemajaController extends Controller
{
    private function getRemaja()
    {
        $user = Auth::user();
        $nik = $user->nik ?? ($user->profile->nik ?? null);
        if (empty($nik)) return Remaja::where('nama_lengkap', $user->name)->first();
        return Remaja::where('nik', $nik)->first();
    }

    public function index()
    {
        $remaja = $this->getRemaja();
        if (!$remaja) return view('user.remaja.empty');
        
        // INTEGRASI BIDAN: Baca langsung dari Pemeriksaan yang verified
        $pemeriksaanTerakhir = Pemeriksaan::where('pasien_id', $remaja->id)
            ->where('kategori_pasien', 'remaja')
            ->where('status_verifikasi', 'verified')
            ->orderBy('tanggal_periksa', 'desc')
            ->first();

        $riwayatPemeriksaan = Pemeriksaan::where('pasien_id', $remaja->id)
            ->where('kategori_pasien', 'remaja')
            ->where('status_verifikasi', 'verified')
            ->orderBy('tanggal_periksa', 'desc')
            ->take(5)
            ->get();
            
        return view('user.remaja.index', compact('remaja', 'pemeriksaanTerakhir', 'riwayatPemeriksaan'));
    }

    public function konseling()
    {
        $remaja = $this->getRemaja();
        if (!$remaja) return view('user.remaja.empty');

        $riwayatKonseling = KonselingRemaja::where('remaja_id', $remaja->id)
            ->orderBy('created_at', 'desc')->get();

        return view('user.remaja.konseling', compact('remaja', 'riwayatKonseling'));
    }
}