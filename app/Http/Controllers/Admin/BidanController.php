<?php
/**
 * PATH   : app/Http/Controllers/Admin/BidanController.php
 * FUNGSI : CRUD akun bidan — login via email
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class BidanController extends Controller
{
    // ── INDEX ───────────────────────────────────
    public function index(Request $request)
    {
        $query = User::with('profile')->where('role', 'bidan');

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

        $bidans = $query->latest()->paginate($request->per_page ?? 15)->withQueryString();
        $stats  = $this->getStats();

        return view('admin.bidans.index', compact('bidans', 'stats'));
    }

    // ── CREATE ──────────────────────────────────
    public function create()
    {
        return view('admin.bidans.create');
    }

    // ── STORE ───────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:191',
            'email'     => 'required|email|unique:users,email',
            'nik'       => 'required|digits:16|unique:users,nik|unique:profiles,nik',
            'status'    => 'required|in:active,inactive',
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
                'role'     => 'bidan',
                'status'   => $request->status,
            ]);

            $user->profile()->create([
                'user_id'   => $user->id,
                'full_name' => $request->full_name,
                'nik'       => $request->nik,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BidanController::store — ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal membuat akun bidan.');
        }

        return redirect()->route('admin.bidans.index')
            ->with('success', 'Akun bidan berhasil dibuat.')
            ->with('generated_password', $password)
            ->with('user_name', $request->full_name)
            ->with('user_email', $request->email);
    }

    // ── SHOW ────────────────────────────────────
    public function show($id)
    {
        $bidan = User::with('profile')->where('role', 'bidan')->findOrFail($id);
        return view('admin.bidans.show', compact('bidan'));
    }

    // ── EDIT ────────────────────────────────────
    public function edit($id)
    {
        $bidan = User::with('profile')->where('role', 'bidan')->findOrFail($id);
        return view('admin.bidans.edit', compact('bidan'));
    }

    // ── UPDATE ──────────────────────────────────
    public function update(Request $request, $id)
    {
        $bidan = User::with('profile')->where('role', 'bidan')->findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:191',
            'status'    => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $bidan->update(['name' => $request->full_name, 'status' => $request->status]);

            if ($bidan->profile) {
                $bidan->profile->update(['full_name' => $request->full_name]);
            } else {
                $bidan->profile()->create(['user_id' => $bidan->id, 'full_name' => $request->full_name]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data bidan.');
        }

        return redirect()->route('admin.bidans.show', $id)
            ->with('success', 'Data bidan berhasil diperbarui.');
    }

    // ── DESTROY ─────────────────────────────────
    public function destroy($id)
    {
        $bidan = User::where('role', 'bidan')->findOrFail($id);
        $name  = $bidan->profile?->full_name ?? $bidan->name;
        $bidan->delete();

        return redirect()->route('admin.bidans.index')
            ->with('success', "Akun bidan {$name} berhasil dihapus.");
    }

    // ── RESET PASSWORD ───────────────────────────
    // Default: 6 digit terakhir NIK + "Bdn!"
    public function resetPassword($id)
    {
        $bidan    = User::where('role', 'bidan')->findOrFail($id);
        $nik      = $bidan->profile?->nik ?? $bidan->nik ?? '0000000000000000';
        $password = substr($nik, -6) . 'Bdn!';
        $bidan->update(['password' => Hash::make($password)]);

        return redirect()->route('admin.bidans.index')
            ->with('success', 'Password bidan berhasil direset.')
            ->with('reset_password', $password)
            ->with('reset_name', $bidan->profile?->full_name ?? $bidan->name)
            ->with('reset_email', $bidan->email);
    }

    // ── HELPERS ─────────────────────────────────
    private function getStats(): array
    {
        try {
            return [
                'total'    => User::where('role', 'bidan')->count(),
                'aktif'    => User::where('role', 'bidan')->where('status', 'active')->count(),
                'nonaktif' => User::where('role', 'bidan')->where('status', 'inactive')->count(),
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