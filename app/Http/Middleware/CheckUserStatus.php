<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status !== 'active') {

                // ✅ FIX: Jika request AJAX (polling notifikasi dll),
                // jangan redirect — return JSON 401
                // Redirect dari AJAX = loop tak berenti
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'status'  => 'inactive',
                        'message' => 'Akun tidak aktif.'
                    ], 401);
                }

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'login' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.'
                ]);
            }
        }

        return $next($request);
    }
}