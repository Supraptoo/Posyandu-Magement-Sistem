<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Konsultasi;
use App\Models\KonselingRemaja;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        $konsultasis = Konsultasi::with(['kunjungan.pasien'])
            ->where('konsultan_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('bidan.konsultasi.index', compact('konsultasis'));
    }

    public function create($kunjungan_id)
    {
        $kunjungan = Kunjungan::with(['pasien'])->findOrFail($kunjungan_id);
        return view('bidan.konsultasi.create', compact('kunjungan'));
    }

    public function store(Request $request, $kunjungan_id)
    {
        $kunjungan = Kunjungan::findOrFail($kunjungan_id);
        
        $request->validate([
            'topik' => 'required|string|max:255',
            'keluhan' => 'required|string',
            'saran' => 'required|string',
            'tindak_lanjut' => 'nullable|string',
        ]);

        $konsultasi = Konsultasi::create([
            'kunjungan_id' => $kunjungan_id,
            'konsultan_id' => auth()->id(),
            'topik' => $request->topik,
            'keluhan' => $request->keluhan,
            'saran' => $request->saran,
            'tindak_lanjut' => $request->tindak_lanjut,
        ]);

        // Jika konsultasi untuk remaja, buat juga data konseling remaja
        if ($kunjungan->pasien_type == 'App\Models\Remaja') {
            $this->createKonselingRemaja($konsultasi, $kunjungan->pasien_id, $request);
        }

        return redirect()->route('bidan.konsultasi.show', $konsultasi->id)
            ->with('success', 'Konsultasi berhasil disimpan');
    }

    public function show($id)
    {
        $konsultasi = Konsultasi::with(['kunjungan.pasien', 'konsultan.profile', 'konselingRemaja'])
            ->findOrFail($id);
            
        return view('bidan.konsultasi.show', compact('konsultasi'));
    }

    private function createKonselingRemaja($konsultasi, $remaja_id, $request)
    {
        KonselingRemaja::create([
            'remaja_id' => $remaja_id,
            'bidan_id' => auth()->id(),
            'konsultasi_id' => $konsultasi->id,
            'tanggal_konseling' => now(),
            'topik_konseling' => $request->topik,
            'keluhan' => $request->keluhan,
            'hasil_assessment' => $request->saran,
            'rencana_tindakan' => $request->tindak_lanjut,
            'jadwal_tindak_lanjut' => $request->tindak_lanjut ? now()->addWeek() : null,
        ]);
    }
}