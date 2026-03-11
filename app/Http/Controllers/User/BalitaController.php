<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Pemeriksaan;
use App\Models\Imunisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BalitaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $nik  = $this->detectNik($user);

        $dataBalita = Balita::where(function ($q) use ($nik, $user) {
                if ($nik) {
                    $q->where('nik_ibu', $nik)
                      ->orWhere('nik_ayah', $nik)
                      ->orWhere('nik', $nik);
                }
                $q->orWhere('user_id', $user->id);
            })
            ->orderBy('tanggal_lahir', 'desc')
            ->get();

        // Untuk setiap balita, ambil riwayat pemeriksaan + imunisasi sekaligus
        $dataBalita = $dataBalita->map(function ($balita) {
            $tgl   = Carbon::parse($balita->tanggal_lahir);
            $diff  = $tgl->diff(now());

            $balita->usia_tahun = $diff->y;
            $balita->usia_bulan = $diff->m;
            $balita->usia_hari  = $diff->d;

            $balita->riwayatPemeriksaan = Pemeriksaan::where('pasien_id', $balita->id)
                ->where('kategori_pasien', 'balita')
                ->orderBy('tanggal_periksa', 'desc')
                ->get();

            $balita->riwayatImunisasi = Imunisasi::whereHas('kunjungan', function ($q) use ($balita) {
                    $q->where('pasien_id', $balita->id)
                      ->where('pasien_type', 'App\Models\Balita');
                })
                ->orderBy('tanggal_imunisasi', 'desc')
                ->get();

            return $balita;
        });

        if ($dataBalita->isEmpty()) {
            return view('user.balita.index', [
                'dataBalita' => $dataBalita,
                'pesan'      => empty($nik)
                    ? 'NIK tidak ditemukan di profil Anda. Silakan lengkapi profil atau hubungi kader.'
                    : 'Belum ada data balita untuk NIK ' . $nik . '. Hubungi kader untuk verifikasi.',
            ]);
        }

        return view('user.balita.index', compact('dataBalita'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $nik  = $this->detectNik($user);

        $balita = Balita::where(function ($q) use ($nik, $user) {
                if ($nik) {
                    $q->where('nik_ibu', $nik)
                      ->orWhere('nik_ayah', $nik)
                      ->orWhere('nik', $nik);
                }
                $q->orWhere('user_id', $user->id);
            })
            ->where('id', $id)
            ->first();

        if (!$balita) {
            return redirect()->route('user.balita.index')
                ->with('error', 'Data balita tidak ditemukan atau bukan milik Anda.');
        }

        $riwayatPemeriksaan = Pemeriksaan::where('pasien_id', $balita->id)
            ->where('kategori_pasien', 'balita')
            ->orderBy('tanggal_periksa', 'desc')
            ->get();

        $riwayatImunisasi = Imunisasi::whereHas('kunjungan', function ($q) use ($balita) {
                $q->where('pasien_id', $balita->id)
                  ->where('pasien_type', 'App\Models\Balita');
            })
            ->orderBy('tanggal_imunisasi', 'desc')
            ->get();

        $diff       = Carbon::parse($balita->tanggal_lahir)->diff(now());
        $usia_tahun = $diff->y;
        $usia_bulan = $diff->m;
        $usia_hari  = $diff->d;

        return view('user.balita.show', compact(
            'balita', 'riwayatPemeriksaan', 'riwayatImunisasi',
            'usia_tahun', 'usia_bulan', 'usia_hari'
        ));
    }

    public function imunisasi()
    {
        $user = auth()->user();
        $nik  = $this->detectNik($user);

        $balitaIds = Balita::where(function ($q) use ($nik, $user) {
                if ($nik) {
                    $q->where('nik_ibu', $nik)
                      ->orWhere('nik_ayah', $nik)
                      ->orWhere('nik', $nik);
                }
                $q->orWhere('user_id', $user->id);
            })
            ->pluck('id');

        $riwayatImunisasi = Imunisasi::whereHas('kunjungan', function ($q) use ($balitaIds) {
                $q->whereIn('pasien_id', $balitaIds)
                  ->where('pasien_type', 'App\Models\Balita');
            })
            ->with(['kunjungan.pasien'])
            ->orderBy('tanggal_imunisasi', 'desc')
            ->get();

        return view('user.balita.imunisasi', compact('riwayatImunisasi'));
    }

    private function detectNik($user)
    {
        if (!empty($user->nik)) return $user->nik;
        if ($user->profile && !empty($user->profile->nik)) return $user->profile->nik;
        if (!empty($user->username) && is_numeric($user->username)) return $user->username;
        return null;
    }
}