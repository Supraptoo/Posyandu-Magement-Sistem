<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Imunisasi;
use Illuminate\Http\Request;

class ImunisasiController extends Controller
{
    public function index()
    {
        $imunisasis = Imunisasi::with(['kunjungan.pasien'])
            ->whereHas('kunjungan', function($query) {
                $query->where('petugas_id', auth()->id());
            })
            ->latest()
            ->paginate(10);
            
        return view('kader.imunisasi.index', compact('imunisasis'));
    }

    public function create($kunjungan_id)
    {
        $kunjungan = Kunjungan::with(['pasien'])->findOrFail($kunjungan_id);
        
        // Pastikan kunjungan untuk imunisasi
        if ($kunjungan->jenis_kunjungan != 'imunisasi') {
            return back()->with('error', 'Kunjungan ini bukan untuk imunisasi');
        }
        
        return view('kader.imunisasi.create', compact('kunjungan'));
    }

    public function store(Request $request, $kunjungan_id)
    {
        $kunjungan = Kunjungan::findOrFail($kunjungan_id);
        
        $request->validate([
            'jenis_imunisasi' => 'required|string|max:255',
            'vaksin' => 'required|string|max:255',
            'dosis' => 'required|string|max:50',
            'tanggal_imunisasi' => 'required|date',
            'batch_number' => 'required|string|max:100',
            'expiry_date' => 'required|date',
            'penyelenggara' => 'required|string|max:255',
        ]);

        Imunisasi::create([
            'kunjungan_id' => $kunjungan_id,
            'jenis_imunisasi' => $request->jenis_imunisasi,
            'vaksin' => $request->vaksin,
            'dosis' => $request->dosis,
            'tanggal_imunisasi' => $request->tanggal_imunisasi,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
            'penyelenggara' => $request->penyelenggara,
        ]);

        return redirect()->route('kader.kunjungan.show', $kunjungan_id)
            ->with('success', 'Data imunisasi berhasil disimpan');
    }

    public function show($id)
    {
        $imunisasi = Imunisasi::with(['kunjungan.pasien'])
            ->findOrFail($id);
            
        return view('kader.imunisasi.show', compact('imunisasi'));
    }

    public function destroy($id)
    {
        $imunisasi = Imunisasi::findOrFail($id);
        $kunjungan_id = $imunisasi->kunjungan_id;
        $imunisasi->delete();

        return redirect()->route('kader.kunjungan.show', $kunjungan_id)
            ->with('success', 'Data imunisasi berhasil dihapus');
    }
}