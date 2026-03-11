<?php
/**
 * PATH   : app/Http/Controllers/Admin/SettingController.php
 * FUNGSI : Pengaturan sistem — profil posyandu, ganti password admin
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    private array $settingKeys = [
        'posyandu_name', 'posyandu_alamat', 'posyandu_telepon',
        'posyandu_email', 'posyandu_kelurahan', 'posyandu_kecamatan',
        'posyandu_kota', 'posyandu_kode_pos',
    ];

    public function index()
    {
        $settings = [];
        try {
            $rows = DB::table('settings')
                ->whereIn('key', $this->settingKeys)->get()->keyBy('key');
            foreach ($this->settingKeys as $k) {
                $settings[$k] = $rows[$k]->value ?? '';
            }
        } catch (\Throwable $e) {
            foreach ($this->settingKeys as $k) $settings[$k] = '';
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'posyandu_name'    => 'required|string|max:191',
            'posyandu_telepon' => 'nullable|string|max:20',
            'posyandu_email'   => 'nullable|email|max:191',
        ]);

        foreach ($this->settingKeys as $k) {
            DB::table('settings')->updateOrInsert(
                ['key' => $k],
                ['key' => $k, 'value' => $request->input($k, ''), 'group' => 'posyandu', 'updated_at' => now()]
            );
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ], [
            'new_password.min'       => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Password admin berhasil diubah.');
    }
}