<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                // Redirect berdasarkan role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'bidan':
                        return redirect()->route('bidan.dashboard');
                    case 'kader':
                        return redirect()->route('kader.dashboard');
                    case 'user':
                        return redirect()->route('user.dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}