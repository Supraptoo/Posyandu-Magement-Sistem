<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BalitaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $balitas = Balita::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kode_balita', 'like', "%{$search}%")
                    ->orWhere('nama_ibu', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);
            
        return view('kader.data.balita.index', compact('balitas', 'search'));
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
            
        return view('kader.data.balita.create', compact('orangtua'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:balitas,nik',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
            'created_by' => 'required|exists:users,id',
        ]);

        $kode = 'BLT-' . date('Ym') . str_pad(Balita::count() + 1, 3, '0', STR_PAD_LEFT);

        Balita::create([
            'kode_balita' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'alamat' => $request->alamat,
            'berat_lahir' => $request->berat_lahir,
            'panjang_lahir' => $request->panjang_lahir,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('kader.data.balita.index')
            ->with('success', 'Data balita berhasil ditambahkan');
    }

    public function show($id)
    {
        $balita = Balita::with(['kunjungans.imunisasis', 'kunjungans.vitamins', 'creator.profile'])
            ->findOrFail($id);
            
        // Hitung usia
        $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
        $usia_tahun = floor($usia_bulan / 12);
        $sisa_bulan = $usia_bulan % 12;
        
        return view('kader.data.balita.show', compact('balita', 'usia_tahun', 'sisa_bulan'));
    }

    public function edit($id)
    {
        $balita = Balita::findOrFail($id);
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
            
        return view('kader.data.balita.edit', compact('balita', 'orangtua'));
    }

    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);
            
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:balitas,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
            'created_by' => 'required|exists:users,id',
        ]);

        $balita->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'alamat' => $request->alamat,
            'berat_lahir' => $request->berat_lahir,
            'panjang_lahir' => $request->panjang_lahir,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('kader.data.balita.show', $id)
            ->with('success', 'Data balita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Cek apakah ada kunjungan terkait
        if ($balita->kunjungans()->count() > 0) {
            return redirect()->route('kader.data.balita.index')
                ->with('error', 'Tidak dapat menghapus balita karena memiliki riwayat kunjungan');
        }
            
        $balita->delete();

        return redirect()->route('kader.data.balita.index')
            ->with('success', 'Data balita berhasil dihapus');
    }
}