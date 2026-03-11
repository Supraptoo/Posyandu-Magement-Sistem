<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\JadwalPosyandu;
use App\Models\Notifikasi;
use App\Models\Pemeriksaan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ✅ FIX 1: Wrap semua query dalam try-catch
        // Jika ada tabel belum ada / error query → tidak redirect ke login
        try {
            $dataPeran  = $this->getPeranUser($user);
            $peranUser  = $dataPeran['roles'];
            $nikUser    = $dataPeran['nik'];
        } catch (\Exception $e) {
            Log::error('DashboardController@getPeranUser: ' . $e->getMessage());
            $peranUser = ['umum'];
            $nikUser   = null;
        }

        $dataAnak   = collect();
        $dataRemaja = null;
        $dataLansia = null;
        $grafikData = [];

        if ($nikUser) {
            try {
                if (in_array('orang_tua', $peranUser)) {
                    $dataAnak = Balita::where(function($q) use ($nikUser) {
                        $q->where('nik_ibu', $nikUser)->orWhere('nik_ayah', $nikUser);
                    })->orderBy('tanggal_lahir', 'desc')->get();

                    if ($dataAnak->isNotEmpty()) {
                        $grafikData = $this->getGrafikBalita($dataAnak->first()->id);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Dashboard balita error: ' . $e->getMessage());
            }

            try {
                if (in_array('remaja', $peranUser)) {
                    $dataRemaja = Remaja::where('nik', $nikUser)->first();
                }
            } catch (\Exception $e) {
                Log::error('Dashboard remaja error: ' . $e->getMessage());
            }

            try {
                if (in_array('lansia', $peranUser)) {
                    $dataLansia = Lansia::where('nik', $nikUser)->first();
                }
            } catch (\Exception $e) {
                Log::error('Dashboard lansia error: ' . $e->getMessage());
            }
        }

        // ✅ FIX 2: Jadwal dengan try-catch
        $jadwalTerdekat = collect();
        try {
            $jadwalTerdekat = $this->getJadwalQuery($peranUser)->take(5)->get();
        } catch (\Exception $e) {
            Log::error('Dashboard jadwal error: ' . $e->getMessage());
        }

        // ✅ FIX 3: Notifikasi dengan try-catch + cek tabel ada
        $notifikasiTerbaru          = collect();
        $totalNotifikasiBelumDibaca = 0;

        try {
            if (Schema::hasTable('notifikasis')) {
                $notifikasiTerbaru = Notifikasi::where('user_id', $user->id)
                    ->latest()->take(5)->get();

                $totalNotifikasiBelumDibaca = Notifikasi::where('user_id', $user->id)
                    ->whereNull('read_at')->count();
            }
        } catch (\Exception $e) {
            Log::error('Dashboard notifikasi error: ' . $e->getMessage());
            // Jangan redirect — biarkan kosong saja
        }

        $statistik = [
            'total_anak' => $dataAnak->count(),
            'notifikasi' => $totalNotifikasiBelumDibaca,
        ];

        $pesanError = empty($nikUser)
            ? 'NIK belum terdaftar di sistem. Mohon lengkapi profil atau hubungi kader.'
            : null;

        return view('user.dashboard', compact(
            'user', 'peranUser', 'dataAnak', 'dataRemaja', 'dataLansia',
            'grafikData', 'jadwalTerdekat', 'notifikasiTerbaru',
            'totalNotifikasiBelumDibaca', 'statistik', 'pesanError'
        ));
    }

    /**
     * ✅ FIX 4: AJAX polling — WAJIB return JSON, JANGAN pernah redirect
     * Ini penyebab utama redirect loop — kalau ini throw exception,
     * Laravel redirect ke /login, lalu JS polling terus → loop tak berenti
     */
    public function getLatestNotifications()
    {
        // Pastikan ini AJAX request
        if (!request()->expectsJson() && !request()->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        }

        try {
            $user = auth()->user();

            // Jika session habis / tidak ada user → return kosong, BUKAN redirect
            if (!$user) {
                return response()->json([
                    'status'      => 'unauthenticated',
                    'notifikasi'  => [],
                    'unread_count'=> 0,
                ], 200); // ← 200 bukan 401, supaya JS tidak error
            }

            // Cek tabel ada dulu
            if (!Schema::hasTable('notifikasis')) {
                return response()->json([
                    'status'      => 'success',
                    'notifikasi'  => [],
                    'unread_count'=> 0,
                ]);
            }

            $notifikasi = Notifikasi::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(fn($n) => [
                    'id'      => $n->id,
                    'judul'   => $n->judul,
                    'pesan'   => Str::limit($n->pesan, 80),
                    'waktu'   => $n->created_at->diffForHumans(),
                    'is_read' => $n->read_at !== null,
                    'type'    => $n->type ?? 'info',
                ]);

            $unreadCount = Notifikasi::where('user_id', $user->id)
                ->whereNull('read_at')->count();

            return response()->json([
                'status'      => 'success',
                'notifikasi'  => $notifikasi,
                'unread_count'=> $unreadCount,
            ]);

        } catch (\Exception $e) {
            Log::error('getLatestNotifications error: ' . $e->getMessage());

            // ✅ KRUSIAL: Jangan throw, jangan redirect → return JSON kosong
            return response()->json([
                'status'      => 'success',
                'notifikasi'  => [],
                'unread_count'=> 0,
            ], 200);
        }
    }

    public function notifikasi()
    {
        $user = auth()->user();

        try {
            $notifikasi = Notifikasi::where('user_id', $user->id)
                ->latest()->paginate(10);

            Notifikasi::where('user_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        } catch (\Exception $e) {
            Log::error('Notifikasi page error: ' . $e->getMessage());
            $notifikasi = collect()->paginate(10) ?? new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        return view('user.notifikasi.index', compact('notifikasi'));
    }

    // ==========================================
    // PRIVATE HELPERS
    // ==========================================

    private function getPeranUser($user): array
    {
        $roles = [];
        $nik   = $user->nik ?? ($user->profile->nik ?? null);

        if ($nik) {
            if (Balita::where('nik_ibu', $nik)->orWhere('nik_ayah', $nik)->exists()) {
                $roles[] = 'orang_tua';
            }
            if (Remaja::where('nik', $nik)->exists()) $roles[] = 'remaja';
            if (Lansia::where('nik', $nik)->exists())  $roles[] = 'lansia';
        }

        if (empty($roles)) $roles[] = 'umum';

        return ['nik' => $nik, 'roles' => $roles];
    }

    private function getJadwalQuery($peranUser)
    {
        $targets = ['semua'];
        if (in_array('orang_tua', $peranUser)) $targets[] = 'balita';
        if (in_array('remaja', $peranUser))    $targets[] = 'remaja';
        if (in_array('lansia', $peranUser))    $targets[] = 'lansia';

        return JadwalPosyandu::where('status', 'aktif')
            ->whereIn('target_peserta', $targets)
            ->orderBy('tanggal', 'desc');
    }

    private function getGrafikBalita($balitaId): array
    {
        $riwayat = Pemeriksaan::where('pasien_id', $balitaId)
            ->where('kategori_pasien', 'balita')
            ->orderBy('tanggal_periksa', 'asc')
            ->take(12)
            ->get();

        if ($riwayat->isEmpty()) return [];

        return [
            'labels' => $riwayat->map(fn($i) => Carbon::parse($i->tanggal_periksa)->format('d M y'))->toArray(),
            'berat'  => $riwayat->pluck('berat_badan')->toArray(),
            'tinggi' => $riwayat->pluck('tinggi_badan')->toArray(),
        ];
    }
}