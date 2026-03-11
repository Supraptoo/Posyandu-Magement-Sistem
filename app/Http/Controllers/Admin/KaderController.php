<?php
/**
 * PATH   : app/Http/Controllers/Admin/KaderController.php
 * FUNGSI : CRUD akun kader — login via email, simpan ke tabel kaders
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class KaderController extends Controller
{
    // ── INDEX ───────────────────────────────────
    public function index(Request $request)
    {
        $query = User::with(['profile', 'kader'])->where('role', 'kader');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', fn($p) =>
                      $p->where('full_name', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                  );
            });
        }
        if ($request->status) $query->where('status', $request->status);

        $kaders = $query->latest()->paginate($request->per_page ?? 15)->withQueryString();
        $stats  = $this->getStats();

        return view('admin.kaders.index', compact('kaders', 'stats'));
    }

    // ── CREATE ──────────────────────────────────
    public function create()
    {
        return view('admin.kaders.create');
    }

    // ── STORE ───────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'full_name'         => 'required|string|max:191',
            'email'             => 'required|email|unique:users,email',
            'nik'               => 'required|digits:16|unique:users,nik|unique:profiles,nik',
            'jenis_kelamin'     => 'required|in:L,P',
            'telepon'           => 'required|string|max:20',
            'alamat'            => 'required|string',
            'jabatan'           => 'required|string|max:191',
            'tanggal_bergabung' => 'required|date',
            'status_kader'      => 'required|in:aktif,nonaktif',
            'status'            => 'required|in:active,inactive',
        ], [
            'email.unique' => 'Email ini sudah digunakan.',
            'nik.digits'   => 'NIK harus 16 digit angka.',
            'nik.unique'   => 'NIK ini sudah terdaftar.',
        ]);

        $password = $this->makePassword();

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->full_name,
                'email'    => $request->email,
                'nik'      => $request->nik,
                'password' => Hash::make($password),
                'role'     => 'kader',
                'status'   => $request->status,
            ]);

            $user->profile()->create([
                'user_id'       => $user->id,
                'full_name'     => $request->full_name,
                'nik'           => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telepon'       => $request->telepon,
                'alamat'        => $request->alamat,
            ]);

            // Simpan ke tabel kaders
            DB::table('kaders')->insert([
                'user_id'           => $user->id,
                'jabatan'           => $request->jabatan,
                'tanggal_bergabung' => $request->tanggal_bergabung,
                'status_kader'      => $request->status_kader,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('KaderController::store — ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat akun kader.');
        }

        return redirect()->route('admin.kaders.index')
            ->with('success', 'Akun kader berhasil dibuat.')
            ->with('generated_password', $password)
            ->with('user_name', $request->full_name)
            ->with('user_email', $request->email);
    }

    // ── SHOW ────────────────────────────────────
    public function show($id)
    {
        $kader = User::with(['profile', 'kader'])->where('role', 'kader')->findOrFail($id);
        return view('admin.kaders.show', compact('kader'));
    }

    // ── EDIT ────────────────────────────────────
    public function edit($id)
    {
        $kader = User::with(['profile', 'kader'])->where('role', 'kader')->findOrFail($id);
        return view('admin.kaders.edit', compact('kader'));
    }

    // ── UPDATE ──────────────────────────────────
    public function update(Request $request, $id)
    {
        $kader = User::with(['profile', 'kader'])->where('role', 'kader')->findOrFail($id);

        $request->validate([
            'full_name'         => 'required|string|max:191',
            'jenis_kelamin'     => 'required|in:L,P',
            'telepon'           => 'required|string|max:20',
            'alamat'            => 'required|string',
            'jabatan'           => 'required|string|max:191',
            'tanggal_bergabung' => 'required|date',
            'status_kader'      => 'required|in:aktif,nonaktif',
            'status'            => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $kader->update(['name' => $request->full_name, 'status' => $request->status]);

            $profileData = [
                'full_name'     => $request->full_name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telepon'       => $request->telepon,
                'alamat'        => $request->alamat,
            ];
            if ($kader->profile) {
                $kader->profile->update($profileData);
            } else {
                $kader->profile()->create(array_merge($profileData, ['user_id' => $kader->id]));
            }

            DB::table('kaders')->where('user_id', $kader->id)->update([
                'jabatan'           => $request->jabatan,
                'tanggal_bergabung' => $request->tanggal_bergabung,
                'status_kader'      => $request->status_kader,
                'updated_at'        => now(),
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data kader.');
        }

        return redirect()->route('admin.kaders.show', $id)
            ->with('success', 'Data kader berhasil diperbarui.');
    }

    // ── DESTROY ─────────────────────────────────
    public function destroy($id)
    {
        $kader = User::where('role', 'kader')->findOrFail($id);
        $name  = $kader->profile?->full_name ?? $kader->name;
        DB::table('kaders')->where('user_id', $kader->id)->delete();
        $kader->delete();

        return redirect()->route('admin.kaders.index')
            ->with('success', "Akun kader {$name} berhasil dihapus.");
    }

    // ── RESET PASSWORD ───────────────────────────
    public function resetPassword($id)
    {
        $kader    = User::where('role', 'kader')->findOrFail($id);
        $nik      = $kader->profile?->nik ?? $kader->nik ?? '0000000000000000';
        $password = substr($nik, -6) . 'Kdr!';
        $kader->update(['password' => Hash::make($password)]);

        return redirect()->route('admin.kaders.index')
            ->with('success', 'Password kader berhasil direset.')
            ->with('reset_password', $password)
            ->with('reset_name', $kader->profile?->full_name ?? $kader->name)
            ->with('reset_email', $kader->email);
    }

    // ── HELPERS ─────────────────────────────────
    private function getStats(): array
    {
        try {
            return [
                'total'    => User::where('role', 'kader')->count(),
                'aktif'    => User::where('role', 'kader')->where('status', 'active')->count(),
                'nonaktif' => User::where('role', 'kader')->where('status', 'inactive')->count(),
            ];
        } catch (\Throwable $e) {
            return ['total' => 0, 'aktif' => 0, 'nonaktif' => 0];
        }
    }

    private function makePassword(): string
    {
        $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789!@#';
        $out   = '';
        for ($i = 0; $i < 8; $i++) $out .= $chars[random_int(0, strlen($chars) - 1)];
        return $out;
    }
}