<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias untuk route middleware - GUNAKAN NAMA TANPA TITIK!
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'checkstatus' => \App\Http\Middleware\CheckUserStatus::class,
            'logactivity' => \App\Http\Middleware\LogUserActivity::class,
        ]);
        
        // PENTING: Jangan tambahkan middleware 'role' atau 'checkstatus' 
        // ke global middleware atau middleware groups!
        // Biarkan hanya dipanggil di route yang membutuhkan.
        
        // Redirect if authenticated
        $middleware->redirectGuestsTo('/login');
        
        // Redirect based on role when accessing guest routes
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            
            if (!$user) {
                return '/login';
            }
            
            return match(strtolower($user->role)) {
                'admin' => '/admin/dashboard',
                'bidan' => '/bidan/dashboard',
                'kader' => '/kader/dashboard',
                'user' => '/user/dashboard',
                default => '/home',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();