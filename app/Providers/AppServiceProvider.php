<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            // A. Settings
            $settings = cache()->remember('app_settings', 3600, function () {
                try { return Setting::getAll(); } catch (\Exception $e) { return []; }
            });
            $view->with('settings', $settings);

            // B. Peran User untuk Sidebar
            $peranUser = ['umum'];

            if (Auth::check() && Auth::user()->role === 'user') {
                $user    = Auth::user();

                // Deteksi NIK: kolom nik → profile->nik → username numerik
                $nikUser = $user->nik ?? ($user->profile?->nik ?? null);
                if (empty($nikUser) && !empty($user->username) && is_numeric($user->username)) {
                    $nikUser = $user->username;
                }

                $peranDitemukan = [];

                try {
                    // ✅ FIX: cek nik_ibu/nik_ayah DAN kolom nik balita DAN user_id
                    $adaBalita = Balita::where(function ($q) use ($nikUser) {
                            $q->where('nik_ibu', $nikUser)
                              ->orWhere('nik_ayah', $nikUser)
                              ->orWhere('nik', $nikUser);   // ← NIK balita itu sendiri
                        })
                        ->orWhere('user_id', $user->id)     // ← linked via user_id
                        ->exists();

                    if ($adaBalita) {
                        $peranDitemukan[] = 'orang_tua';
                    }
                } catch (\Exception $e) {}

                try {
                    if ($nikUser && Remaja::where('nik', $nikUser)->exists()) {
                        $peranDitemukan[] = 'remaja';
                    }
                } catch (\Exception $e) {}

                try {
                    if ($nikUser && Lansia::where('nik', $nikUser)->exists()) {
                        $peranDitemukan[] = 'lansia';
                    }
                } catch (\Exception $e) {}

                if (!empty($peranDitemukan)) {
                    $peranUser = $peranDitemukan;
                }
            }

            $view->with('peranUser', $peranUser);
        });
    }
}