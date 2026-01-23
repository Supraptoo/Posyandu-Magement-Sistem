<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Show change password form
     */
    public function showChangeForm()
    {
        return view('auth.change-password', [
            'title' => 'Ganti Password'
        ]);
    }

    /**
     * Handle password change
     */
    public function change(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.'
            ])->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
            'password_changed_at' => now(),
        ]);

        // Redirect berdasarkan role
        $route = match($user->role) {
            'admin' => 'admin.dashboard',
            'bidan' => 'bidan.dashboard',
            'kader' => 'kader.dashboard',
            'user' => 'user.dashboard',
            default => 'home',
        };

        return redirect()->route($route)
            ->with('success', 'Password berhasil diubah!');
    }
}