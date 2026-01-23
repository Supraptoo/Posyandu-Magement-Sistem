<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Menggunakan getAll() atau getAllWithDefaults()
        $settings = Setting::getAllWithDefaults();
        
        return view('admin.settings.index', [
            'title' => 'Pengaturan Sistem',
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_posyandu' => 'required|string|max:255',
            'alamat_posyandu' => 'required|string',
            'telepon_posyandu' => 'required|string|max:20',
            'email_posyandu' => 'required|email|max:255',
            'kepala_posyandu' => 'required|string|max:255',
            'jam_operasional' => 'required|string|max:255',
        ]);

        // Gunakan setMany untuk efisiensi
        Setting::setMany($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}