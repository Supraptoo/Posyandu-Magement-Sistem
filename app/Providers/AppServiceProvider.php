<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings with all views
        view()->composer('*', function ($view) {
            $settings = cache()->remember('app_settings', 3600, function () {
                return Setting::getAll();
            });
            
            $view->with('settings', $settings);
        });
        
        // Set default string length for MySQL
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    }
}