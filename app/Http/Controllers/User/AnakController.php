<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Kunjungan;
use App\Models\Imunisasi;
use App\Models\Vitamin;
use Illuminate\Http\Request;

class AnakController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $anak = Balita::where('created_by', $user->id)
            ->with(['kunjungans' => function($query) {
                $query->latest()->take(5);
            }])
            ->get();
            
        return view('user.anak.index', compact('anak'));
    }

    public function show($id)
    {
        $anak = Balita::with(['kunjungans' => function($query) {
                $query->with(['imunisasis', 'vitamins', 'pemeriksaan', 'konsultasi'])
                    ->latest();
            }])
            ->where('created_by', auth()->id())
            ->findOrFail($id);
            
        $riwayatImunisasi = Imunisasi::whereHas('kunjungan', function($query) use ($id) {
                $query->where('pasien_id', $id)
                    ->where('pasien_type', 'App\Models\Balita');
            })
            ->latest()
            ->get();
            
        $riwayatVitamin = Vitamin::whereHas('kunjungan', function($query) use ($id) {
                $query->where('pasien_id', $id)
                    ->where('pasien_type', 'App\Models\Balita');
            })
            ->latest()
            ->get();
            
        return view('user.anak.show', compact('anak', 'riwayatImunisasi', 'riwayatVitamin'));
    }

    public function create()
    {
        return view('user.anak.create');
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
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('user.anak.index')
            ->with('success', 'Data anak berhasil ditambahkan');
    }

    public function edit($id)
    {
        $anak = Balita::where('created_by', auth()->id())
            ->findOrFail($id);
            
        return view('user.anak.edit', compact('anak'));
    }

    public function update(Request $request, $id)
    {
        $anak = Balita::where('created_by', auth()->id())
            ->findOrFail($id);
            
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:balitas,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat' => 'required|string',
        ]);

        $anak->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('user.anak.show', $id)
            ->with('success', 'Data anak berhasil diperbarui');
    }

    public function destroy($id)
    {
        $anak = Balita::where('created_by', auth()->id())
            ->findOrFail($id);
            
        $anak->delete();

        return redirect()->route('user.anak.index')
            ->with('success', 'Data anak berhasil dihapus');
    }
}