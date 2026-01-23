<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::where('petugas_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('kader.kunjungan.index', compact('kunjungan'));
    }
    
    public function create()
    {
        return view('kader.kunjungan.create');
    }
    
    public function store(Request $request)
    {
        // Implementasi simpan kunjungan
        return redirect()->route('kader.kunjungan.index')
            ->with('success', 'Kunjungan berhasil dicatat');
    }
    
    public function show($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        return view('kader.kunjungan.show', compact('kunjungan'));
    }
}