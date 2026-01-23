<?php
?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Log activity hanya untuk user yang sudah login
        if (Auth::check() && $this->shouldLog($request)) {
            $user = Auth::user();
            
            // Update last login time untuk request login
            if ($request->routeIs('login')) {
                $user->last_login_at = now();
                $user->save();
            }
            
            // Log aktivitas lainnya bisa ditambahkan di sini
            // Contoh: log aktivitas penting ke database
            if ($this->isImportantActivity($request)) {
                $this->logToDatabase($user, $request);
            }
        }
        
        return $response;
    }

    /**
     * Determine if the request should be logged
     */
    private function shouldLog(Request $request): bool
    {
        // Jangan log request untuk asset, API, atau metode tertentu
        $excludedMethods = ['OPTIONS', 'HEAD'];
        $excludedPaths = [
            'css',
            'js',
            'img',
            'favicon',
            'storage',
            'api',
            'login',
            'logout',
            'password',
        ];
        
        if (in_array($request->method(), $excludedMethods)) {
            return false;
        }
        
        foreach ($excludedPaths as $path) {
            if (strpos($request->path(), $path) === 0) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Determine if this is an important activity to log
     */
    private function isImportantActivity(Request $request): bool
    {
        $importantRoutes = [
            'admin.*',
            'bidan.*',
            'kader.*',
            'user.*',
            'profile.*',
        ];
        
        foreach ($importantRoutes as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Log activity to database
     */
    private function logToDatabase(User $user, Request $request)
    {
        // Contoh implementasi logging ke database
        // Uncomment jika ingin mengimplementasi
        
        /*
        \App\Models\UserActivity::create([
            'user_id' => $user->id,
            'activity' => $this->getActivityDescription($request),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);
        */
    }

    /**
     * Get description for the activity
     */
    private function getActivityDescription(Request $request): string
    {
        $routeName = $request->route()->getName();
        
        return match(true) {
            strpos($routeName, 'admin.') === 0 => 'Admin Activity: ' . $routeName,
            strpos($routeName, 'bidan.') === 0 => 'Bidan Activity: ' . $routeName,
            strpos($routeName, 'kader.') === 0 => 'Kader Activity: ' . $routeName,
            strpos($routeName, 'user.') === 0 => 'User Activity: ' . $routeName,
            default => 'General Activity: ' . $request->path(),
        };
    }
}