<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\JadwalPosyandu;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user    = Auth::user();
        $nikUser = $user->nik ?? null;

        // 1. Tentukan hak akses target peserta
        $hakAkses = ['semua'];
        if ($nikUser) {
            try {
                if (Balita::where('nik_ibu', $nikUser)->orWhere('nik_ayah', $nikUser)->exists())
                    $hakAkses[] = 'balita';
            } catch (\Throwable $e) { Log::warning('Jadwal balita check: ' . $e->getMessage()); }

            try {
                if (Remaja::where('nik', $nikUser)->exists()) $hakAkses[] = 'remaja';
            } catch (\Throwable $e) { Log::warning('Jadwal remaja check: ' . $e->getMessage()); }

            try {
                if (Lansia::where('nik', $nikUser)->exists()) $hakAkses[] = 'lansia';
            } catch (\Throwable $e) { Log::warning('Jadwal lansia check: ' . $e->getMessage()); }
        }

        // 2. Filter tab aktif dari query string
        // Nilai valid: semua, balita, remaja, lansia, ibu_hamil
        $filterTarget = $request->get('filter', 'semua');
        $validFilters = ['semua', 'balita', 'remaja', 'lansia', 'ibu_hamil'];
        if (!in_array($filterTarget, $validFilters)) {
            $filterTarget = 'semua';
        }

        // 3. Bangun query
        $query = JadwalPosyandu::aktif()
            ->whereIn('target_peserta', $hakAkses);

        // Terapkan filter tab jika bukan 'semua'
        if ($filterTarget !== 'semua') {
            $query->where('target_peserta', $filterTarget);
        }

        // Urutan: akan datang (ASC) dulu, lalu yang sudah lewat (DESC)
        // Caranya: pisah jadi 2 query, gabung via union tidak bisa di paginate,
        // jadi pakai orderByRaw dengan CASE
        $query->orderByRaw("
            CASE
                WHEN tanggal >= CURDATE() THEN 0
                ELSE 1
            END ASC,
            CASE
                WHEN tanggal >= CURDATE() THEN tanggal
                ELSE NULL
            END ASC,
            CASE
                WHEN tanggal < CURDATE() THEN tanggal
                ELSE NULL
            END DESC,
            waktu_mulai ASC
        ");

        $jadwalKegiatan = $query->paginate(9)->withQueryString();

        // 4. Hitung summary untuk badge tab
        $baseQuery = JadwalPosyandu::aktif()->whereIn('target_peserta', $hakAkses);
        $summary = [
            'semua'    => (clone $baseQuery)->count(),
            'balita'   => (clone $baseQuery)->where('target_peserta', 'balita')->count(),
            'remaja'   => (clone $baseQuery)->where('target_peserta', 'remaja')->count(),
            'lansia'   => (clone $baseQuery)->where('target_peserta', 'lansia')->count(),
            'mendatang'=> (clone $baseQuery)->whereDate('tanggal', '>=', Carbon::today())->count(),
        ];

        return view('user.jadwal.index', compact(
            'jadwalKegiatan', 'hakAkses', 'filterTarget', 'summary'
        ));
    }
}