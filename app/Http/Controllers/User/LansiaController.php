<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LansiaController extends Controller
{
    /**
     * Menampilkan halaman utama kesehatan lansia
     */
    public function index()
    {
        $user = auth()->user();
        
        // === DETEKSI NIK DARI BERBAGAI SUMBER ===
        $nik = null;
        
        // Cek dari tabel users
        if (!empty($user->nik)) {
            $nik = $user->nik;
        }
        
        // Cek dari profile jika ada
        if (empty($nik) && $user->profile && !empty($user->profile->nik)) {
            $nik = $user->profile->nik;
        }
        
        // Cek dari username jika berupa angka (NIK)
        if (empty($nik) && is_numeric($user->username)) {
            $nik = $user->username;
        }
        
        // Log untuk debugging
        Log::info('User NIK:', ['nik' => $nik, 'user_id' => $user->id]);
        
        // Jika tidak ada NIK sama sekali
        if (empty($nik)) {
            return view('user.lansia.empty', [
                'message' => 'NIK tidak ditemukan di profil Anda. Silakan lengkapi profil atau hubungi kader.'
            ]);
        }
        
        // Cari data lansia berdasarkan NIK
        $lansia = Lansia::where('nik', $nik)->first();
        
        // Jika tidak ditemukan, coba cari berdasarkan nama (fallback)
        if (!$lansia && $user->name) {
            $lansia = Lansia::where('nama_lengkap', 'like', '%' . $user->name . '%')->first();
        }
        
        // Log hasil pencarian
        Log::info('Lansia ditemukan:', ['found' => $lansia ? 'yes' : 'no']);
        
        if (!$lansia) {
            return view('user.lansia.empty', [
                'nik' => $nik,
                'message' => 'Data lansia dengan NIK ' . $nik . ' tidak ditemukan. Silakan hubungi kader untuk pendaftaran.'
            ]);
        }
        
        // === AMBIL RIWAYAT PEMERIKSAAN ===
        
        // Method 1: Langsung dari tabel pemeriksaans
        $riwayatPemeriksaan = Pemeriksaan::where('pasien_id', $lansia->id)
            ->where('kategori_pasien', 'lansia')
            ->orderBy('tanggal_periksa', 'desc')
            ->get();
        
        // Method 2: Via kunjungan (jika method 1 kosong)
        if ($riwayatPemeriksaan->isEmpty()) {
            $kunjungans = Kunjungan::where('pasien_id', $lansia->id)
                ->where('pasien_type', 'App\Models\Lansia')
                ->with('pemeriksaan')
                ->orderBy('tanggal_kunjungan', 'desc')
                ->get();
            
            foreach ($kunjungans as $kunjungan) {
                if ($kunjungan->pemeriksaan) {
                    $riwayatPemeriksaan->push($kunjungan->pemeriksaan);
                }
            }
        }
        
        // Hitung statistik
        $stats = [
            'total_kunjungan' => $riwayatPemeriksaan->count(),
            'kunjungan_terakhir' => $riwayatPemeriksaan->first(),
            'usia' => $lansia->usia ?? Carbon::parse($lansia->tanggal_lahir)->age,
        ];
        
        return view('user.lansia.index', compact('lansia', 'riwayatPemeriksaan', 'stats'));
    }

    /**
     * Menampilkan detail kunjungan tertentu
     */
    public function showKunjungan($id)
    {
        $user = auth()->user();
        
        // Deteksi NIK
        $nik = $this->detectNik($user);
        
        if (!$nik) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'NIK tidak ditemukan');
        }
        
        $lansia = Lansia::where('nik', $nik)->first();
        
        if (!$lansia) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'Data lansia tidak ditemukan');
        }
        
        $kunjungan = Kunjungan::where('pasien_id', $lansia->id)
            ->where('pasien_type', 'App\Models\Lansia')
            ->where('id', $id)
            ->with(['pemeriksaan', 'konsultasi'])
            ->first();
        
        if (!$kunjungan) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'Kunjungan tidak ditemukan');
        }
        
        return view('user.lansia.kunjungan', compact('kunjungan', 'lansia'));
    }

    /**
     * Menampilkan form edit profil
     */
    public function editProfile()
    {
        $user = auth()->user();
        
        // Deteksi NIK
        $nik = $this->detectNik($user);
        
        if (!$nik) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'NIK tidak ditemukan');
        }
        
        $lansia = Lansia::where('nik', $nik)->first();
        
        if (!$lansia) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'Data lansia tidak ditemukan');
        }
        
        return view('user.lansia.edit', compact('lansia'));
    }

    /**
     * Update profil lansia
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        // Deteksi NIK
        $nik = $this->detectNik($user);
        
        if (!$nik) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'NIK tidak ditemukan');
        }
        
        $lansia = Lansia::where('nik', $nik)->first();
        
        if (!$lansia) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'Data lansia tidak ditemukan');
        }
        
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
        } else {
            $user->profile()->create([
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]);
        }

        return redirect()->route('user.lansia.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Menampilkan riwayat medis lengkap
     */
    public function riwayatMedis()
    {
        $user = auth()->user();
        
        // Deteksi NIK
        $nik = $this->detectNik($user);
        
        if (!$nik) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'NIK tidak ditemukan');
        }
        
        $lansia = Lansia::where('nik', $nik)->first();
        
        if (!$lansia) {
            return redirect()->route('user.lansia.index')
                ->with('error', 'Data lansia tidak ditemukan');
        }
        
        // Ambil semua kunjungan yang memiliki pemeriksaan
        $kunjungans = Kunjungan::where('pasien_id', $lansia->id)
            ->where('pasien_type', 'App\Models\Lansia')
            ->with(['pemeriksaan'])
            ->whereHas('pemeriksaan')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(15);
        
        // Transformasi data untuk view
        $riwayat = collect();
        foreach ($kunjungans as $kunjungan) {
            if ($kunjungan->pemeriksaan) {
                $item = $kunjungan->pemeriksaan;
                $item->tanggal_kunjungan = $kunjungan->tanggal_kunjungan;
                $item->kode_kunjungan = $kunjungan->kode_kunjungan;
                $riwayat->push($item);
            }
        }
        
        return view('user.lansia.riwayat', compact('lansia', 'riwayat', 'kunjungans'));
    }

    /**
     * Helper untuk mendeteksi NIK dari berbagai sumber
     */
    private function detectNik($user)
    {
        if (!empty($user->nik)) {
            return $user->nik;
        }
        
        if ($user->profile && !empty($user->profile->nik)) {
            return $user->profile->nik;
        }
        
        if (!empty($user->username) && is_numeric($user->username)) {
            return $user->username;
        }
        
        return null;
    }
}