<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::with('profile')
            ->where('role', 'user')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', [
            'title' => 'Manajemen Warga',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create', [
            'title' => 'Tambah User Baru'
        ]);
    }

    /**
     * Store a newly created user
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'nik' => 'required|string|size:16|unique:users,nik',
        'full_name' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required|string',
        'telepon' => 'nullable|string|max:20',
        'tempat_lahir' => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'status' => 'required|in:active,inactive',
    ], [
        'nik.required' => 'NIK wajib diisi',
        'nik.size' => 'NIK harus 16 digit',
        'nik.unique' => 'NIK sudah terdaftar',
        'full_name.required' => 'Nama lengkap wajib diisi',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
        'alamat.required' => 'Alamat wajib diisi',
    ]);

    DB::beginTransaction();
    try {
        // Generate password dari NIK
        $password = substr($validated['nik'], -6); // Ambil 6 digit terakhir NIK

        // Buat user
        $userData = [
            'nik' => $validated['nik'],
            'password' => Hash::make($password),
            'role' => 'user',
            'status' => $validated['status'],
            'name' => $validated['full_name'], // HARUS ADA - kolom name wajib
            'email' => $validated['nik'] . '@posyandu.user', // Buat email dari NIK
        ];
        
        // Tambahkan created_by hanya jika kolomnya ada
        if (Schema::hasColumn('users', 'created_by')) {
            $userData['created_by'] = Auth::id();
        }
        
        $user = User::create($userData);

        // Buat profile
        Profile::create([
            'user_id' => $user->id,
            'full_name' => $validated['full_name'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'telepon' => $validated['telepon'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
        ]);

        DB::commit();

        // Simpan password ke session untuk ditampilkan
        session()->flash('generated_password', $password);
        session()->flash('user_nik', $validated['nik']);
        session()->flash('user_name', $validated['full_name']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()])
            ->withInput();
    }
}

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('admin.users.show', [
            'title' => 'Detail User',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('admin.users.edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified user
     */
   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'nik' => 'required|string|size:16|unique:users,nik,' . $user->id,
        'full_name' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required|string',
        'telepon' => 'nullable|string|max:20',
        'tempat_lahir' => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'status' => 'required|in:active,inactive',
    ]);

    DB::beginTransaction();
    try {
        // Update user
        $user->update([
            'nik' => $validated['nik'],
            'status' => $validated['status'],
            'name' => $validated['full_name'], // Update name juga
        ]);

        // Update profile
        if ($user->profile) {
            $user->profile->update([
                'full_name' => $validated['full_name'],
                'nik' => $validated['nik'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'telepon' => $validated['telepon'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);
        } else {
            // Jika profile tidak ada, buat baru
            Profile::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'nik' => $validated['nik'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'telepon' => $validated['telepon'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);
        }

        DB::commit();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Gagal mengupdate user: ' . $e->getMessage()])
            ->withInput();
    }
}

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Cek apakah user ini adalah admin
            if ($user->role === 'admin') {
                return back()->withErrors(['error' => 'Admin tidak dapat dihapus!']);
            }

            // Hapus user (profile akan terhapus otomatis karena cascade)
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus user: ' . $e->getMessage()]);
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword($id)
    {
        try {
            $user = User::findOrFail($id);

            // Generate password baru (6 digit terakhir NIK)
            $newPassword = substr($user->nik, -6);

            // Update password
            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            // Simpan password ke session
            session()->flash('reset_password', $newPassword);
            session()->flash('reset_nik', $user->nik);
            session()->flash('reset_name', $user->profile ? $user->profile->full_name : 'N/A');

            return redirect()->route('admin.users.index')
                ->with('success', 'Password berhasil direset!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mereset password: ' . $e->getMessage()]);
        }
    }
}