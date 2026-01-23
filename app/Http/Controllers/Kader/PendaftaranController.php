<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('kader.pendaftaran.index');
    }
    
    public function create($type = 'balita')
    {
        return view('kader.pendaftaran.create', compact('type'));
    }
    
    public function store(Request $request, $type)
    {
        // Validasi dan simpan berdasarkan type
        // Implementasi sesuai kebutuhan
        return redirect()->route('kader.dashboard')
            ->with('success', 'Pendaftaran berhasil disimpan');
    }
}