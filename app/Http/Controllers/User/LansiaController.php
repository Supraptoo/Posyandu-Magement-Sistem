<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $lansia = Lansia::where('nik', $user->nik)->first();
        
        if (!$lansia) {
            return view('user.lansia.empty');
        }
        
        $kunjungans = Kunjungan::where('pasien_id', $lansia->id)
            ->where('pasien_type', 'App\Models\Lansia')
            ->with(['pemeriksaan', 'konsultasi'])
            ->latest()
            ->paginate(10);
            
        $stats = [
            'total_kunjungan' => $kunjungans->total(),
            'kunjungan_terakhir' => $kunjungans->first(),
            'usia' => $lansia->usia,
        ];
        
        return view('user.lansia.index', compact('lansia', 'kunjungans', 'stats'));
    }

    public function showKunjungan($id)
    {
        $user = auth()->user();
        $lansia = Lansia::where('nik', $user->nik)->firstOrFail();
        
        $kunjungan = Kunjungan::where('pasien_id', $lansia->id)
            ->where('pasien_type', 'App\Models\Lansia')
            ->where('id', $id)
            ->with(['pemeriksaan', 'konsultasi'])
            ->firstOrFail();
            
        return view('user.lansia.kunjungan', compact('kunjungan', 'lansia'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        $lansia = Lansia::where('nik', $user->nik)->firstOrFail();
        
        return view('user.lansia.edit', compact('lansia'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $lansia = Lansia::where('nik', $user->nik)->firstOrFail();
        
        $request->validate([
            'alamat' => 'required|string',
            'penyakit_bawaan' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $lansia->update([
            'alamat' => $request->alamat,
            'penyakit_bawaan' => $request->penyakit_bawaan,
        ]);

        // Update profile user juga
        if ($user->profile) {
            $user->profile()->update([
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);
        }

        return redirect()->route('user.lansia.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function riwayatMedis()
    {
        $user = auth()->user();
        $lansia = Lansia::where('nik', $user->nik)->firstOrFail();
        
        $kunjungans = Kunjungan::where('pasien_id', $lansia->id)
            ->where('pasien_type', 'App\Models\Lansia')
            ->with(['pemeriksaan'])
            ->whereHas('pemeriksaan')
            ->latest()
            ->get();
            
        return view('user.lansia.riwayat', compact('lansia', 'kunjungans'));
    }
}