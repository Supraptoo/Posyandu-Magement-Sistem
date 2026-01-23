<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KaderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $kaders = User::where('role', 'kader')
            ->with(['profile', 'kader'])
            ->when($search, function($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('email', 'like', "%{$search}%")
                          ->orWhere('name', 'like', "%{$search}%")
                          ->orWhereHas('profile', function($q) use ($search) {
                              $q->where('full_name', 'like', "%{$search}%")
                                ->orWhere('nik', 'like', "%{$search}%");
                          })
                          ->orWhereHas('kader', function($q) use ($search) {
                              $q->where('jabatan', 'like', "%{$search}%");
                          });
                });
            })
            ->latest()
            ->paginate(15);
            
        return view('admin.kaders.index', compact('kaders', 'search'));
    }

    public function create()
    {
        return view('admin.kaders.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
        'full_name' => 'required|string|max:255',
        'nik' => 'required|max:16|min:16',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required|string|max:500',
        'telepon' => 'required|string|max:20',
        'jabatan' => 'required|string|max:100',
        'status_kader' => 'required|in:aktif,nonaktif',
        'tanggal_bergabung' => 'required|date|before_or_equal:today',
        'status' => 'required|in:active,inactive',
    ]);

    DB::beginTransaction();
    
    try {
        // Generate password otomatis
        $password = Str::random(8);
        
        // Buat user dengan email sebagai login
        $userData = [
            'name' => $request->full_name, // HARUS ADA - kolom name wajib
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'kader',
            'status' => $request->status,
        ];
        
        // Tambahkan created_by hanya jika kolomnya ada
        if (Schema::hasColumn('users', 'created_by')) {
            $userData['created_by'] = auth()->id();
        }
        
        $user = User::create($userData);
        
        // Buat profile
        Profile::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);
        
        // Buat data kader khusus
        Kader::create([
            'user_id' => $user->id,
            'jabatan' => $request->jabatan,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'status_kader' => $request->status_kader,
        ]);
        
        DB::commit();
        
        return redirect()->route('admin.kaders.index')
            ->with('success', 'Kader berhasil dibuat. Email: ' . $request->email . ' Password: ' . $password)
            ->with('password', $password)
            ->with('email', $request->email);
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal membuat kader: ' . $e->getMessage())->withInput();
    }
}

    public function show($id)
    {
        $kader = User::with(['profile', 'kader'])->findOrFail($id);
        
        // Pastikan user adalah kader
        if ($kader->role !== 'kader') {
            abort(404);
        }
        
        return view('admin.kaders.show', compact('kader'));
    }

    public function edit($id)
    {
        $kader = User::with(['profile', 'kader'])->findOrFail($id);
        
        // Pastikan user adalah kader
        if ($kader->role !== 'kader') {
            abort(404);
        }
        
        return view('admin.kaders.edit', compact('kader'));
    }

   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    // Pastikan user adalah kader
    if ($user->role !== 'kader') {
        abort(404);
    }
    
    $request->validate([
        'full_name' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required|string|max:500',
        'telepon' => 'required|string|max:20',
        'jabatan' => 'required|string|max:100',
        'status_kader' => 'required|in:aktif,nonaktif',
        'status' => 'required|in:active,inactive',
        'tanggal_bergabung' => 'required|date|before_or_equal:today',
    ]);

    DB::beginTransaction();
    
    try {
        // Update user status dan name
        $user->update([
            'status' => $request->status,
            'name' => $request->full_name, // Update name juga
        ]);
        
        // Update profile
        $user->profile()->update([
            'full_name' => $request->full_name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);
        
        // Update data kader
        $user->kader()->update([
            'jabatan' => $request->jabatan,
            'status_kader' => $request->status_kader,
            'tanggal_bergabung' => $request->tanggal_bergabung,
        ]);
        
        DB::commit();
        
        return redirect()->route('admin.kaders.show', $user->id)
            ->with('success', 'Data kader berhasil diperbarui');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui kader: ' . $e->getMessage())->withInput();
    }
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan user adalah kader
        if ($user->role !== 'kader') {
            abort(404);
        }
        
        DB::beginTransaction();
        
        try {
            // Hapus data kader
            $user->kader()->delete();
            
            // Hapus profile
            $user->profile()->delete();
            
            // Hapus user
            $user->delete();
            
            DB::commit();
            
            return redirect()->route('admin.kaders.index')
                ->with('success', 'Kader berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus kader: ' . $e->getMessage());
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan user adalah kader
        if ($user->role !== 'kader') {
            abort(404);
        }
        
        $newPassword = Str::random(8);
        $user->update(['password' => Hash::make($newPassword)]);
        
        return back()->with('success', 'Password berhasil direset. Password baru: ' . $newPassword)
                     ->with('password', $newPassword);
    }
}