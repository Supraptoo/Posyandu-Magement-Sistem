<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        
        // ==================== DATA ANAK BALITA ====================
        $anakBalita = [];
        if ($profile && $profile->nik) {
            // Cari anak balita berdasarkan NIK orang tua (nama_ibu atau nama_ayah)
            $anakBalita = DB::table('balitas')
                ->where(function($query) use ($profile) {
                    $query->where('nama_ibu', 'like', '%' . $profile->full_name . '%')
                          ->orWhere('nama_ayah', 'like', '%' . $profile->full_name . '%')
                          ->orWhere('nik', $profile->nik);
                })
                ->whereDate('tanggal_lahir', '>', Carbon::now()->subYears(5))
                ->orderBy('tanggal_lahir', 'desc')
                ->get()
                ->map(function ($balita) {
                    // Hitung usia dalam bulan
                    $usiaBulan = Carbon::parse($balita->tanggal_lahir)->diffInMonths(Carbon::now());
                    $usiaTahun = floor($usiaBulan / 12);
                    $sisaBulan = $usiaBulan % 12;
                    
                    // Ambil pemeriksaan terakhir
                    $pemeriksaanTerakhir = DB::table('kunjungans')
                        ->join('pemeriksaans', 'kunjungans.id', '=', 'pemeriksaans.kunjungan_id')
                        ->where('kunjungans.pasien_id', $balita->id)
                        ->where('kunjungans.pasien_type', 'App\\Models\\Balita')
                        ->where('kunjungans.jenis_kunjungan', 'pemeriksaan')
                        ->orderBy('kunjungans.tanggal_kunjungan', 'desc')
                        ->select('pemeriksaans.*', 'kunjungans.tanggal_kunjungan')
                        ->first();
                    
                    // Ambri imunisasi terakhir
                    $imunisasiTerakhir = DB::table('kunjungans')
                        ->join('imunisasis', 'kunjungans.id', '=', 'imunisasis.kunjungan_id')
                        ->where('kunjungans.pasien_id', $balita->id)
                        ->where('kunjungans.pasien_type', 'App\\Models\\Balita')
                        ->where('kunjungans.jenis_kunjungan', 'imunisasi')
                        ->orderBy('imunisasis.tanggal_imunisasi', 'desc')
                        ->select('imunisasis.*')
                        ->first();
                    
                    return [
                        'id' => $balita->id,
                        'kode_balita' => $balita->kode_balita,
                        'nama_lengkap' => $balita->nama_lengkap,
                        'tanggal_lahir' => $balita->tanggal_lahir,
                        'jenis_kelamin' => $balita->jenis_kelamin,
                        'usia_bulan' => $usiaBulan,
                        'usia_tahun' => $usiaTahun,
                        'sisa_bulan' => $sisaBulan,
                        'usia_formatted' => $usiaTahun > 0 ? $usiaTahun . ' tahun ' . $sisaBulan . ' bulan' : $usiaBulan . ' bulan',
                        'pemeriksaan_terakhir' => $pemeriksaanTerakhir,
                        'imunisasi_terakhir' => $imunisasiTerakhir
                    ];
                });
        }
        
        // ==================== DATA USER SEBAGAI REMAJA ====================
        $dataRemaja = null;
        if ($profile && $profile->nik) {
            $dataRemaja = DB::table('remajas')
                ->where('nik', $profile->nik)
                ->first();
            
            if ($dataRemaja) {
                // Hitung usia remaja
                $usiaRemaja = Carbon::parse($dataRemaja->tanggal_lahir)->diffInYears(Carbon::now());
                $dataRemaja->usia = $usiaRemaja;
                
                // Ambil pemeriksaan terakhir
                $pemeriksaanTerakhirRemaja = DB::table('kunjungans')
                    ->join('pemeriksaans', 'kunjungans.id', '=', 'pemeriksaans.kunjungan_id')
                    ->where('kunjungans.pasien_id', $dataRemaja->id)
                    ->where('kunjungans.pasien_type', 'App\\Models\\Remaja')
                    ->where('kunjungans.jenis_kunjungan', 'pemeriksaan')
                    ->orderBy('kunjungans.tanggal_kunjungan', 'desc')
                    ->select('pemeriksaans.*', 'kunjungans.tanggal_kunjungan')
                    ->first();
                    
                $dataRemaja->pemeriksaan_terakhir = $pemeriksaanTerakhirRemaja;
            }
        }
        
        // ==================== DATA USER SEBAGAI LANSIA ====================
        $dataLansia = null;
        if ($profile && $profile->nik) {
            $dataLansia = DB::table('lansias')
                ->where('nik', $profile->nik)
                ->first();
            
            if ($dataLansia) {
                // Hitung usia lansia
                $usiaLansia = Carbon::parse($dataLansia->tanggal_lahir)->diffInYears(Carbon::now());
                $dataLansia->usia = $usiaLansia;
                
                // Ambil pemeriksaan terakhir
                $pemeriksaanTerakhirLansia = DB::table('kunjungans')
                    ->join('pemeriksaans', 'kunjungans.id', '=', 'pemeriksaans.kunjungan_id')
                    ->where('kunjungans.pasien_id', $dataLansia->id)
                    ->where('kunjungans.pasien_type', 'App\\Models\\Lansia')
                    ->where('kunjungans.jenis_kunjungan', 'pemeriksaan')
                    ->orderBy('kunjungans.tanggal_kunjungan', 'desc')
                    ->select('pemeriksaans.*', 'kunjungans.tanggal_kunjungan')
                    ->first();
                    
                $dataLansia->pemeriksaan_terakhir = $pemeriksaanTerakhirLansia;
            }
        }
        
        // ==================== JADWAL POSYANDU TERDEKAT ====================
        $jadwalTerdekat = DB::table('jadwal_posyandu')
            ->where('status', 'aktif')
            ->where('tanggal', '>=', Carbon::today())
            ->where(function($query) {
                $query->where('target_peserta', 'semua')
                      ->orWhere('target_peserta', 'balita')
                      ->orWhere('target_peserta', 'remaja')
                      ->orWhere('target_peserta', 'lansia');
            })
            ->orderBy('tanggal', 'asc')
            ->limit(5)
            ->get();
        
        // Format tanggal untuk tampilan
        $jadwalTerdekat = $jadwalTerdekat->map(function ($jadwal) {
            $jadwal->tanggal_formatted = Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y');
            $jadwal->hari = Carbon::parse($jadwal->tanggal)->translatedFormat('l');
            return $jadwal;
        });
        
        // ==================== NOTIFIKASI TERBARU ====================
        $notifikasiTerbaru = DB::table('notifikasi_user')
            ->where('user_id', $user->id)
            ->where('dibaca', 0)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $totalNotifikasi = DB::table('notifikasi_user')
            ->where('user_id', $user->id)
            ->where('dibaca', 0)
            ->count();
        
        // ==================== GRAFIK PERKEMBANGAN ANAK ====================
        $grafikPerkembangan = [];
        if ($anakBalita->isNotEmpty()) {
            $anakPertama = $anakBalita->first();
            
            $dataGrafik = DB::table('kunjungans as k')
                ->join('pemeriksaans as p', 'k.id', '=', 'p.kunjungan_id')
                ->where('k.pasien_id', $anakPertama['id'])
                ->where('k.pasien_type', 'App\\Models\\Balita')
                ->whereNotNull('p.berat_badan')
                ->orderBy('k.tanggal_kunjungan', 'asc')
                ->select('p.berat_badan', 'p.tinggi_badan', 'k.tanggal_kunjungan')
                ->limit(10)
                ->get();
            
            if ($dataGrafik->isNotEmpty()) {
                $grafikPerkembangan = [
                    'labels' => $dataGrafik->map(function($item) {
                        return Carbon::parse($item->tanggal_kunjungan)->format('d M');
                    })->toArray(),
                    'berat_badan' => $dataGrafik->pluck('berat_badan')->toArray(),
                    'tinggi_badan' => $dataGrafik->pluck('tinggi_badan')->toArray(),
                ];
            }
        }
        
        // ==================== STATISTIK ====================
        $statistik = [
            'total_anak' => $anakBalita->count(),
            'total_imunisasi' => $anakBalita->sum(function($anak) {
                return $anak['imunisasi_terakhir'] ? 1 : 0;
            }),
            'total_kunjungan' => $anakBalita->sum(function($anak) {
                return $anak['pemeriksaan_terakhir'] ? 1 : 0;
            }),
            'notifikasi' => $totalNotifikasi,
        ];
        
        return view('user.dashboard', compact(
            'profile',
            'anakBalita',
            'dataRemaja',
            'dataLansia',
            'jadwalTerdekat',
            'notifikasiTerbaru',
            'totalNotifikasi',
            'grafikPerkembangan',
            'statistik',
            'user'
        ));
    }
    
    /**
     * Get quick stats for dashboard widgets
     */
    public function getStats()
    {
        $user = Auth::user();
        $profile = DB::table('profiles')->where('user_id', $user->id)->first();
        
        $stats = [
            'total_anak' => 0,
            'jadwal_mendatang' => 0,
            'notifikasi' => 0,
            'pemeriksaan_terakhir' => null,
        ];
        
        if ($profile && $profile->nik) {
            // Hitung total anak
            $stats['total_anak'] = DB::table('balitas')
                ->where(function($query) use ($profile) {
                    $query->where('nama_ibu', 'like', '%' . $profile->full_name . '%')
                          ->orWhere('nama_ayah', 'like', '%' . $profile->full_name . '%')
                          ->orWhere('nik', $profile->nik);
                })
                ->whereDate('tanggal_lahir', '>', Carbon::now()->subYears(5))
                ->count();
            
            // Jadwal mendatang (7 hari ke depan)
            $stats['jadwal_mendatang'] = DB::table('jadwal_posyandu')
                ->where('status', 'aktif')
                ->where('tanggal', '>=', Carbon::today())
                ->where('tanggal', '<=', Carbon::today()->addDays(7))
                ->count();
            
            // Notifikasi belum dibaca
            $stats['notifikasi'] = DB::table('notifikasi_user')
                ->where('user_id', $user->id)
                ->where('dibaca', 0)
                ->count();
            
            // Pemeriksaan terakhir untuk semua anak
            $anakBalita = DB::table('balitas')
                ->where(function($query) use ($profile) {
                    $query->where('nama_ibu', 'like', '%' . $profile->full_name . '%')
                          ->orWhere('nama_ayah', 'like', '%' . $profile->full_name . '%')
                          ->orWhere('nik', $profile->nik);
                })
                ->get();
            
            if ($anakBalita->isNotEmpty()) {
                $latestPemeriksaan = DB::table('kunjungans')
                    ->join('pemeriksaans', 'kunjungans.id', '=', 'pemeriksaans.kunjungan_id')
                    ->whereIn('kunjungans.pasien_id', $anakBalita->pluck('id')->toArray())
                    ->where('kunjungans.pasien_type', 'App\\Models\\Balita')
                    ->where('kunjungans.jenis_kunjungan', 'pemeriksaan')
                    ->orderBy('kunjungans.tanggal_kunjungan', 'desc')
                    ->select('pemeriksaans.*', 'kunjungans.tanggal_kunjungan')
                    ->first();
                
                $stats['pemeriksaan_terakhir'] = $latestPemeriksaan ? 
                    Carbon::parse($latestPemeriksaan->tanggal_kunjungan)->translatedFormat('d F Y') : 
                    'Belum ada pemeriksaan';
            }
        }
        
        return response()->json($stats);
    }
}