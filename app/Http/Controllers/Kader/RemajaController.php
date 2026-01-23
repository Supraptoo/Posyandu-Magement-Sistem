<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Remaja;
use App\Models\User;
use Illuminate\Http\Request;

class RemajaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $remajas = Remaja::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kode_remaja', 'like', "%{$search}%")
                    ->orWhere('sekolah', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);
            
        return view('kader.data.remaja.index', compact('remajas', 'search'));
    }

    public function create()
    {
        // Cari user yang role 'user' untuk dijadikan orang tua
        $orangtua = User::where('role', 'user')
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
            
        return view('kader.data.remaja.create', compact('orangtua'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:remajas,nik',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'nama_ortu' => 'nullable|string|max:255',
            'telepon_ortu' => 'nullable|string|max:20',
            'created_by' => 'required|exists:users,id',
        ]);

        $kode = 'RMJ-' . date('Ym') . str_pad(Remaja::count() + 1, 3, '0', STR_PAD_LEFT);

        Remaja::create([
            'kode_remaja' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'sekolah' => $request->sekolah,
            'kelas' => $request->kelas,
            'nama_ortu' => $request->nama_ortu,
            'telepon_ortu' => $request->telepon_ortu,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('kader.data.remaja.index')
            ->with('success', 'Data remaja berhasil ditambahkan');
    }

    public function show($id)
    {
        $remaja = Remaja::with(['kunjungans.pemeriksaan', 'kunjungans.konsultasi', 'creator.profile'])
            ->findOrFail($id);
            
        // Hitung usia
        $usia_tahun = $remaja->tanggal_lahir->diffInYears(now());
        
        return view('kader.data.remaja.show', compact('remaja', 'usia_tahun'));
    }

   // File: app/Http/Controllers/Kader/RemajaController.php

public function edit($id)
{
    $remaja = Remaja::findOrFail($id);
    
    // Cari user yang role 'user' untuk dijadikan orang tua
    $orangtua = User::where('role', 'user')
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
    
    // Cari bidan untuk konseling (jika diperlukan di view)
    $bidans = User::where('role', 'bidan')
        ->where('status', 'active')
        ->with('profile')
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'nama' => $user->profile->full_name ?? 'Tidak ada nama',
                'email' => $user->email
            ];
        });
    
    return view('kader.data.remaja.edit', compact('remaja', 'orangtua', 'bidans'));
}

    public function update(Request $request, $id)
    {
        $remaja = Remaja::findOrFail($id);
            
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:remajas,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'nama_ortu' => 'nullable|string|max:255',
            'telepon_ortu' => 'nullable|string|max:20',
            'created_by' => 'required|exists:users,id',
        ]);

        $remaja->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'sekolah' => $request->sekolah,
            'kelas' => $request->kelas,
            'nama_ortu' => $request->nama_ortu,
            'telepon_ortu' => $request->telepon_ortu,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('kader.data.remaja.show', $id)
            ->with('success', 'Data remaja berhasil diperbarui');
    }

    public function destroy($id)
    {
        $remaja = Remaja::findOrFail($id);
        
        // Cek apakah ada kunjungan terkait
        if ($remaja->kunjungans()->count() > 0) {
            return redirect()->route('kader.data.remaja.index')
                ->with('error', 'Tidak dapat menghapus remaja karena memiliki riwayat kunjungan');
        }
            
        $remaja->delete();

        return redirect()->route('kader.data.remaja.index')
            ->with('success', 'Data remaja berhasil dihapus');
    }
}