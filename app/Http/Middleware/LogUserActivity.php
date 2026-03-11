<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && $this->shouldLog($request)) {
            $user = Auth::user();

            if ($request->routeIs('login')) {
                try {
                    $user->last_login_at = now();
                    $user->save();
                } catch (\Throwable $e) {
                    // Kolom last_login_at mungkin belum ada, skip saja
                }
            }
        }

        return $response;
    }

    private function shouldLog(Request $request): bool
    {
        if (in_array($request->method(), ['OPTIONS', 'HEAD'])) {
            return false;
        }

        foreach (['css', 'js', 'img', 'favicon', 'storage', 'api', 'login', 'logout', 'password'] as $path) {
            if (strpos($request->path(), $path) === 0) {
                return false;
            }
        }

        return true;
    }
}