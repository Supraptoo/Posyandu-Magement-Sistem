<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Bidan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BidanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $bidans = User::where('role', 'bidan')
            ->with(['profile', 'bidan'])
            ->when($search, function($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('email', 'like', "%{$search}%")
                          ->orWhere('name', 'like', "%{$search}%")
                          ->orWhereHas('profile', function($q) use ($search) {
                              $q->where('full_name', 'like', "%{$search}%")
                                ->orWhere('nik', 'like', "%{$search}%");
                          })
                          ->orWhereHas('bidan', function($q) use ($search) {
                              $q->where('sip', 'like', "%{$search}%")
                                ->orWhere('spesialisasi', 'like', "%{$search}%");
                          });
                });
            })
            ->latest()
            ->paginate(15);
            
        return view('admin.bidans.index', compact('bidans', 'search'));
    }

    public function create()
    {
        return view('admin.bidans.create');
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
        'sip' => 'required|string|max:50|unique:bidans,sip',
        'spesialisasi' => 'required|string|max:100',
        'rumah_sakit' => 'nullable|string|max:255',
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
            'role' => 'bidan',
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
        
        // Buat data bidan khusus
        Bidan::create([
            'user_id' => $user->id,
            'sip' => $request->sip,
            'spesialisasi' => $request->spesialisasi,
            'rumah_sakit' => $request->rumah_sakit,
        ]);
        
        DB::commit();
        
        return redirect()->route('admin.bidans.index')
            ->with('success', 'Bidan berhasil dibuat. Email: ' . $request->email . ' Password: ' . $password)
            ->with('password', $password)
            ->with('email', $request->email);
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal membuat bidan: ' . $e->getMessage())->withInput();
    }
}

    public function show($id)
    {
        $bidan = User::with(['profile', 'bidan'])->findOrFail($id);
        
        // Pastikan user adalah bidan
        if ($bidan->role !== 'bidan') {
            abort(404);
        }
        
        return view('admin.bidans.show', compact('bidan'));
    }

    public function edit($id)
    {
        $bidan = User::with(['profile', 'bidan'])->findOrFail($id);
        
        // Pastikan user adalah bidan
        if ($bidan->role !== 'bidan') {
            abort(404);
        }
        
        return view('admin.bidans.edit', compact('bidan'));
    }

   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    // Pastikan user adalah bidan
    if ($user->role !== 'bidan') {
        abort(404);
    }
    
    $request->validate([
        'full_name' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'alamat' => 'required|string|max:500',
        'telepon' => 'required|string|max:20',
        'sip' => 'required|string|max:50|unique:bidans,sip,' . $user->bidan->id,
        'spesialisasi' => 'required|string|max:100',
        'rumah_sakit' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive',
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
        
        // Update data bidan
        $user->bidan()->update([
            'sip' => $request->sip,
            'spesialisasi' => $request->spesialisasi,
            'rumah_sakit' => $request->rumah_sakit,
        ]);
        
        DB::commit();
        
        return redirect()->route('admin.bidans.show', $user->id)
            ->with('success', 'Data bidan berhasil diperbarui');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui bidan: ' . $e->getMessage())->withInput();
    }
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan user adalah bidan
        if ($user->role !== 'bidan') {
            abort(404);
        }
        
        DB::beginTransaction();
        
        try {
            // Hapus data bidan
            $user->bidan()->delete();
            
            // Hapus profile
            $user->profile()->delete();
            
            // Hapus user
            $user->delete();
            
            DB::commit();
            
            return redirect()->route('admin.bidans.index')
                ->with('success', 'Bidan berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus bidan: ' . $e->getMessage());
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan user adalah bidan
        if ($user->role !== 'bidan') {
            abort(404);
        }
        
        $newPassword = Str::random(8);
        $user->update(['password' => Hash::make($newPassword)]);
        
        return back()->with('success', 'Password berhasil direset. Password baru: ' . $newPassword)
                     ->with('password', $newPassword);
    }
}