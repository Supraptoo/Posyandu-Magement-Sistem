<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Remaja;
use App\Models\Kunjungan;
use App\Models\KonselingRemaja;
use Illuminate\Http\Request;

class RemajaController extends Controller
{
    public function index()
    {
        // Ambil data remaja berdasarkan NIK user yang login
        $user = auth()->user();
        $remaja = Remaja::where('nik', $user->nik)->first();
        
        if (!$remaja) {
            return view('user.remaja.empty');
        }
        
        $kunjungans = Kunjungan::where('pasien_id', $remaja->id)
            ->where('pasien_type', 'App\Models\Remaja')
            ->with(['pemeriksaan', 'konsultasi'])
            ->latest()
            ->get();
            
        $konseling = KonselingRemaja::where('remaja_id', $remaja->id)
            ->latest()
            ->get();
            
        return view('user.remaja.index', compact('remaja', 'kunjungans', 'konseling'));
    }

    public function showPemeriksaan($id)
    {
        $user = auth()->user();
        $remaja = Remaja::where('nik', $user->nik)->firstOrFail();
        
        $kunjungan = Kunjungan::where('pasien_id', $remaja->id)
            ->where('pasien_type', 'App\Models\Remaja')
            ->where('id', $id)
            ->with(['pemeriksaan', 'konsultasi'])
            ->firstOrFail();
            
        return view('user.remaja.pemeriksaan', compact('kunjungan', 'remaja'));
    }

    public function showKonseling($id)
    {
        $user = auth()->user();
        $remaja = Remaja::where('nik', $user->nik)->firstOrFail();
        
        $konseling = KonselingRemaja::where('remaja_id', $remaja->id)
            ->where('id', $id)
            ->with(['bidan.profile'])
            ->firstOrFail();
            
        return view('user.remaja.konseling', compact('konseling', 'remaja'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        $remaja = Remaja::where('nik', $user->nik)->firstOrFail();
        
        return view('user.remaja.edit', compact('remaja'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $remaja = Remaja::where('nik', $user->nik)->firstOrFail();
        
        $request->validate([
            'alamat' => 'required|string',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'telepon_ortu' => 'nullable|string|max:20',
        ]);

        $remaja->update([
            'alamat' => $request->alamat,
            'sekolah' => $request->sekolah,
            'kelas' => $request->kelas,
            'telepon_ortu' => $request->telepon_ortu,
        ]);

        // Update profile user juga
        if ($user->profile) {
            $user->profile()->update([
                'alamat' => $request->alamat,
                'telepon' => $request->telepon_ortu,
            ]);
        }

        return redirect()->route('user.remaja.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}