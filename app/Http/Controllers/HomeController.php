<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'bidan' => redirect()->route('bidan.dashboard'),
                'kader' => redirect()->route('kader.dashboard'),
                'user' => redirect()->route('user.dashboard'),
                default => redirect('/login'),
            };
        }

        // Jika belum login, tampilkan landing page
        return view('welcome');
    }
}