<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->status !== 'active') {
                auth()->logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.'
                ]);
            }
        }

        return $next($request);
    }
}