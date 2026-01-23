<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    // Menampilkan daftar data lansia
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $lansias = Lansia::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kode_lansia', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);
            
        return view('kader.data.lansia.index', compact('lansias', 'search'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        // Ambil data user untuk opsi "Keluarga Terdaftar"
        $pendaftar = User::where('role', 'user')
            ->where('status', 'active')
            ->with('profile')
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->profile->full_name ?? 'Tidak ada nama',
                    'nik' => $user->profile->nik ?? 'Tidak ada NIK'
                ];
            });
            
        return view('kader.data.lansia.create', compact('pendaftar'));
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:lansias,nik',
            'tempat_lahir' => 'required|string|max:100',
            
            // PERBAIKAN: Validasi dilonggarkan.
            // 'before:today' artinya tanggal harus sebelum hari ini (tidak boleh masa depan).
            // Tidak ada batasan minimal 60 tahun lagi, jadi 1982/1988 bisa masuk.
            'tanggal_lahir' => 'required|date|before:today', 
            
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'penyakit_bawaan' => 'nullable|string',
            'telepon_keluarga' => 'nullable|string|max:20', // Menyimpan kontak darurat
            'created_by' => 'required|exists:users,id',
        ]);

        // Generate Kode Unik: LNS-202601001
        $kode = 'LNS-' . date('Ym') . str_pad(Lansia::count() + 1, 3, '0', STR_PAD_LEFT);

        Lansia::create([
            'kode_lansia' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'penyakit_bawaan' => $request->penyakit_bawaan,
            'telepon_keluarga' => $request->telepon_keluarga, 
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('kader.data.lansia.index')
            ->with('success', 'Data lansia berhasil ditambahkan');
    }

    // Menampilkan detail data
    public function show($id)
    {
        $lansia = Lansia::with(['kunjungans.pemeriksaan', 'kunjungans.konsultasi', 'creator.profile'])
            ->findOrFail($id);
            
        // Menghitung usia otomatis
        $usia = $lansia->tanggal_lahir->age;
        
        return view('kader.data.lansia.show', compact('lansia', 'usia'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $lansia = Lansia::findOrFail($id);
        
        $pendaftar = User::where('role', 'user')
            ->where('status', 'active')
            ->with('profile')
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->profile->full_name ?? 'Tidak ada nama',
                    'nik' => $user->profile->nik ?? 'Tidak ada NIK'
                ];
            });
            
        return view('kader.data.lansia.edit', compact('lansia', 'pendaftar'));
    }

    // Memperbarui data di database
    public function update(Request $request, $id)
    {
        $lansia = Lansia::findOrFail($id);
            
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:lansias,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            
            // PERBAIKAN: Sama seperti store, batasan umur dihapus
            'tanggal_lahir' => 'required|date|before:today',
            
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'penyakit_bawaan' => 'nullable|string',
            'telepon_keluarga' => 'nullable|string|max:20',
            'created_by' => 'required|exists:users,id',
        ]);

        $lansia->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'penyakit_bawaan' => $request->penyakit_bawaan,
            'telepon_keluarga' => $request->telepon_keluarga,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('kader.data.lansia.show', $id)
            ->with('success', 'Data lansia berhasil diperbarui');
    }

    // Menghapus data
    public function destroy($id)
    {
        $lansia = Lansia::findOrFail($id);
        
        // Mencegah penghapusan jika data sudah dipakai di tabel kunjungan
        if ($lansia->kunjungans()->count() > 0) {
            return redirect()->route('kader.data.lansia.index')
                ->with('error', 'Tidak dapat menghapus lansia karena memiliki riwayat kunjungan');
        }
            
        $lansia->delete();

        return redirect()->route('kader.data.lansia.index')
            ->with('success', 'Data lansia berhasil dihapus');
    }
}