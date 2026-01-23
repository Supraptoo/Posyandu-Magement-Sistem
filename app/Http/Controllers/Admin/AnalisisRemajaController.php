<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnalisisPemeriksaanRemaja;

class AnalisisRemajaController extends Controller
{
    public function index()
    {
        $analisis = AnalisisPemeriksaanRemaja::with(['pemeriksaan', 'remaja'])
            ->paginate(10);
        return view('admin.analisis-remaja.index', compact('analisis'));
    }

    public function show($id)
    {
        $analisis = AnalisisPemeriksaanRemaja::with(['pemeriksaan', 'remaja'])
            ->findOrFail($id);
        return view('admin.analisis-remaja.show', compact('analisis'));
    }

    public function destroy($id)
    {
        $analisis = AnalisisPemeriksaanRemaja::findOrFail($id);
        $analisis->delete();

        return redirect()->route('admin.analisis-remaja.index')
            ->with('success', 'Analisis berhasil dihapus');
    }
}