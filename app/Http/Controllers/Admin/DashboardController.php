<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginLog;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use App\Models\Imunisasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all dashboard data
        $dashboardData = $this->getAllDashboardData();
        
        return view('admin.dashboard', $dashboardData);
    }

    public function getStats(Request $request)
    {
        $stats = $this->getDashboardStats();
        
        if ($request->ajax()) {
            return response()->json($stats);
        }
        
        return response()->json($stats);
    }

    private function getAllDashboardData()
    {
        // Statistik dasar
        $stats = $this->getDashboardStats();
        
        // Recent activities
        $recentActivities = $this->getRecentActivities();
        
        // Data untuk chart (6 bulan terakhir)
        $chartData = $this->getChartData();
        
        // Data kunjungan dan pemeriksaan hari ini
        $todayActivities = $this->getTodayActivities();
        
        // Top 5 pengguna aktif
        $topActiveUsers = $this->getTopActiveUsers();

        // Gabungkan semua data
        return array_merge([
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'todayActivities' => $todayActivities,
            'topActiveUsers' => $topActiveUsers,
            'months' => $chartData['months'] ?? [],
            'userData' => $chartData['userData'] ?? [],
            'kunjunganData' => $chartData['kunjunganData'] ?? [],
            'pemeriksaanData' => $chartData['pemeriksaanData'] ?? []
        ], $stats); // Juga include stats di root untuk backward compatibility
    }

    private function getDashboardStats()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        
        // Total Users - pastikan menghitung user yang aktif saja
        $totalUsers = User::where('role', 'user')
            ->where('status', 'active')
            ->count();
        
        $totalKaders = User::where('role', 'kader')
            ->where('status', 'active')
            ->count();
        
        $totalBidans = User::where('role', 'bidan')
            ->where('status', 'active')
            ->count();
        
        $totalAdmins = User::where('role', 'admin')
            ->where('status', 'active')
            ->count();
        
        // Total Data Pasien
        $totalBalita = Balita::count();
        $totalRemaja = Remaja::count();
        $totalLansia = Lansia::count();
        
        // Status Aktif/Nonaktif semua user
        $usersActive = User::where('status', 'active')->count();
        $usersInactive = User::where('status', 'inactive')->count();
        
        // Login hari ini
        $loginToday = LoginLog::whereDate('login_at', $today)->count();
        
        // User baru bulan ini
        $newUsersMonth = User::where('created_at', '>=', $startOfMonth)->count();
        
        // User baru tahun ini
        $newUsersYear = User::where('created_at', '>=', $startOfYear)->count();
        
        // Kunjungan hari ini
        try {
            $kunjunganToday = Kunjungan::whereDate('tanggal_kunjungan', $today)->count();
        } catch (\Exception $e) {
            $kunjunganToday = Kunjungan::whereDate('created_at', $today)->count();
        }
        
        // Pemeriksaan hari ini
        try {
            $pemeriksaanToday = Pemeriksaan::whereDate('created_at', $today)->count();
        } catch (\Exception $e) {
            $pemeriksaanToday = 0;
        }
        
        // Imunisasi hari ini
        try {
            $imunisasiToday = Imunisasi::whereDate('tanggal_imunisasi', $today)->count();
        } catch (\Exception $e) {
            $imunisasiToday = Imunisasi::whereDate('created_at', $today)->count();
        }
        
        // Persentase perubahan
        $lastMonth = Carbon::now()->subMonth();
        $startLastMonth = $lastMonth->copy()->startOfMonth();
        $endLastMonth = $lastMonth->copy()->endOfMonth();
        
        $currentMonthUsers = User::whereBetween('created_at', [$startOfMonth, Carbon::now()])->count();
        $lastMonthUsers = User::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        
        $usersChangePercent = $lastMonthUsers > 0 ? 
            (($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 
            ($currentMonthUsers > 0 ? 100 : 0);
        
        $currentMonthKaders = User::where('role', 'kader')
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->count();
        $lastMonthKaders = User::where('role', 'kader')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->count();
        
        $kadersChangePercent = $lastMonthKaders > 0 ? 
            (($currentMonthKaders - $lastMonthKaders) / $lastMonthKaders) * 100 : 
            ($currentMonthKaders > 0 ? 100 : 0);
        
        $currentMonthBidans = User::where('role', 'bidan')
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->count();
        $lastMonthBidans = User::where('role', 'bidan')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->count();
        
        $bidansChangePercent = $lastMonthBidans > 0 ? 
            (($currentMonthBidans - $lastMonthBidans) / $lastMonthBidans) * 100 : 
            ($currentMonthBidans > 0 ? 100 : 0);

        return [
            'total_users' => $totalUsers,
            'total_kaders' => $totalKaders,
            'total_bidans' => $totalBidans,
            'total_admins' => $totalAdmins,
            'total_balita' => $totalBalita,
            'total_remaja' => $totalRemaja,
            'total_lansia' => $totalLansia,
            'users_active' => $usersActive,
            'users_inactive' => $usersInactive,
            'login_today' => $loginToday,
            'new_users_month' => $newUsersMonth,
            'new_users_year' => $newUsersYear,
            'kunjungan_today' => $kunjunganToday,
            'pemeriksaan_today' => $pemeriksaanToday,
            'imunisasi_today' => $imunisasiToday,
            'users_change_percent' => $usersChangePercent,
            'kaders_change_percent' => $kadersChangePercent,
            'bidans_change_percent' => $bidansChangePercent,
        ];
    }

    private function getRecentActivities()
    {
        // 5 user terbaru yang mendaftar
        $newUsers = User::with(['profile'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();
        
        // 5 login terakhir
        $recentLogins = LoginLog::with(['user.profile'])
            ->latest()
            ->take(5)
            ->get();
        
        // 5 kunjungan terbaru
        $recentKunjungan = collect();
        try {
            $recentKunjungan = Kunjungan::with(['pasien', 'petugas'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Skip if error
        }
        
        // 5 pemeriksaan terbaru
        $recentPemeriksaan = collect();
        try {
            $recentPemeriksaan = Pemeriksaan::with(['kunjungan.pasien'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Skip if error
        }

        return [
            'new_users' => $newUsers,
            'recent_logins' => $recentLogins,
            'recent_kunjungan' => $recentKunjungan,
            'recent_pemeriksaan' => $recentPemeriksaan,
        ];
    }

    private function getTodayActivities()
    {
        $today = Carbon::today();
        
        // Kunjungan hari ini
        $kunjunganToday = 0;
        try {
            $kunjunganToday = Kunjungan::whereDate('tanggal_kunjungan', $today)->count();
        } catch (\Exception $e) {
            $kunjunganToday = Kunjungan::whereDate('created_at', $today)->count();
        }
        
        // Pemeriksaan hari ini
        $pemeriksaanToday = 0;
        try {
            $pemeriksaanToday = Pemeriksaan::whereDate('created_at', $today)->count();
        } catch (\Exception $e) {
            // Skip if error
        }
        
        // Imunisasi hari ini
        $imunisasiToday = 0;
        try {
            $imunisasiToday = Imunisasi::whereDate('tanggal_imunisasi', $today)->count();
        } catch (\Exception $e) {
            $imunisasiToday = Imunisasi::whereDate('created_at', $today)->count();
        }
        
        // User baru hari ini
        $newUsersToday = User::whereDate('created_at', $today)->count();

        return [
            'kunjungan_today' => $kunjunganToday,
            'pemeriksaan_today' => $pemeriksaanToday,
            'imunisasi_today' => $imunisasiToday,
            'new_users_today' => $newUsersToday,
        ];
    }

    private function getTopActiveUsers()
    {
        try {
            // Ambil 5 user dengan login terbanyak dalam 30 hari terakhir
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            
            return LoginLog::select('user_id', DB::raw('count(*) as login_count'))
                ->with(['user.profile'])
                ->where('login_at', '>=', $thirtyDaysAgo)
                ->groupBy('user_id')
                ->orderBy('login_count', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    private function getChartData()
    {
        $months = [];
        $userData = [];
        $kunjunganData = [];
        $pemeriksaanData = [];
        
        // Generate data untuk 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $months[] = $date->translatedFormat('M');
            
            // Hitung user baru per bulan
            $userCount = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
            $userData[] = $userCount;
            
            // Hitung kunjungan per bulan
            $kunjunganCount = 0;
            try {
                $kunjunganCount = Kunjungan::whereBetween('tanggal_kunjungan', [$startOfMonth, $endOfMonth])
                    ->count();
            } catch (\Exception $e) {
                $kunjunganCount = Kunjungan::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count();
            }
            $kunjunganData[] = $kunjunganCount;
            
            // Hitung pemeriksaan per bulan
            $pemeriksaanCount = 0;
            try {
                $pemeriksaanCount = Pemeriksaan::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count();
            } catch (\Exception $e) {
                // Skip if error
            }
            $pemeriksaanData[] = $pemeriksaanCount;
        }
        
        return [
            'months' => $months,
            'userData' => $userData,
            'kunjunganData' => $kunjunganData,
            'pemeriksaanData' => $pemeriksaanData
        ];
    }
}