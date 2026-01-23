<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $type = $request->get('type', 'all');
        
        $riwayat = collect();
        
        // Cek apakah user adalah orang tua (punya balita)
        $balitas = Balita::where('created_by', $user->id)->get();
        if ($balitas->isNotEmpty() && ($type == 'all' || $type == 'balita')) {
            foreach ($balitas as $balita) {
                $riwayatBalita = Kunjungan::where('pasien_id', $balita->id)
                    ->where('pasien_type', 'App\Models\Balita')
                    ->with(['pemeriksaan', 'imunisasis', 'vitamins'])
                    ->get();
                    
                foreach ($riwayatBalita as $item) {
                    $item->pasien_nama = $balita->nama_lengkap;
                    $item->pasien_type = 'Balita';
                    $riwayat->push($item);
                }
            }
        }
        
        // Cek apakah user adalah remaja
        $remaja = Remaja::where('nik', $user->nik)->first();
        if ($remaja && ($type == 'all' || $type == 'remaja')) {
            $riwayatRemaja = Kunjungan::where('pasien_id', $remaja->id)
                ->where('pasien_type', 'App\Models\Remaja')
                ->with(['pemeriksaan', 'konsultasi'])
                ->get();
                
            foreach ($riwayatRemaja as $item) {
                $item->pasien_nama = $remaja->nama_lengkap;
                $item->pasien_type = 'Remaja';
                $riwayat->push($item);
            }
        }
        
        // Cek apakah user adalah lansia
        $lansia = Lansia::where('nik', $user->nik)->first();
        if ($lansia && ($type == 'all' || $type == 'lansia')) {
            $riwayatLansia = Kunjungan::where('pasien_id', $lansia->id)
                ->where('pasien_type', 'App\Models\Lansia')
                ->with(['pemeriksaan', 'konsultasi'])
                ->get();
                
            foreach ($riwayatLansia as $item) {
                $item->pasien_nama = $lansia->nama_lengkap;
                $item->pasien_type = 'Lansia';
                $riwayat->push($item);
            }
        }
        
        // Urutkan berdasarkan tanggal
        $riwayat = $riwayat->sortByDesc('tanggal_kunjungan')->paginate(15);
        
        return view('user.riwayat.index', compact('riwayat', 'type'));
    }

    public function show($id, $type)
    {
        $user = auth()->user();
        
        switch ($type) {
            case 'balita':
                // Pastikan user adalah creator dari balita ini
                $balita = Balita::where('created_by', $user->id)
                    ->where('id', $id)
                    ->firstOrFail();
                    
                $riwayat = Kunjungan::where('pasien_id', $balita->id)
                    ->where('pasien_type', 'App\Models\Balita')
                    ->with(['pemeriksaan', 'imunisasis', 'vitamins', 'konsultasi'])
                    ->latest()
                    ->get();
                    
                return view('user.riwayat.detail-balita', compact('balita', 'riwayat'));
                
            case 'remaja':
                $remaja = Remaja::where('nik', $user->nik)
                    ->where('id', $id)
                    ->firstOrFail();
                    
                $riwayat = Kunjungan::where('pasien_id', $remaja->id)
                    ->where('pasien_type', 'App\Models\Remaja')
                    ->with(['pemeriksaan', 'konsultasi'])
                    ->latest()
                    ->get();
                    
                return view('user.riwayat.detail-remaja', compact('remaja', 'riwayat'));
                
            case 'lansia':
                $lansia = Lansia::where('nik', $user->nik)
                    ->where('id', $id)
                    ->firstOrFail();
                    
                $riwayat = Kunjungan::where('pasien_id', $lansia->id)
                    ->where('pasien_type', 'App\Models\Lansia')
                    ->with(['pemeriksaan', 'konsultasi'])
                    ->latest()
                    ->get();
                    
                return view('user.riwayat.detail-lansia', compact('lansia', 'riwayat'));
                
            default:
                abort(404);
        }
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:balita,remaja,lansia',
        ]);

        $user = auth()->user();
        $riwayat = collect();
        
        switch ($request->type) {
            case 'balita':
                $balitas = Balita::where('created_by', $user->id)->get();
                foreach ($balitas as $balita) {
                    $data = Kunjungan::where('pasien_id', $balita->id)
                        ->where('pasien_type', 'App\Models\Balita')
                        ->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date])
                        ->with(['pemeriksaan', 'imunisasis', 'vitamins'])
                        ->get();
                        
                    foreach ($data as $item) {
                        $item->pasien_nama = $balita->nama_lengkap;
                        $riwayat->push($item);
                    }
                }
                break;
                
            case 'remaja':
                $remaja = Remaja::where('nik', $user->nik)->first();
                if ($remaja) {
                    $data = Kunjungan::where('pasien_id', $remaja->id)
                        ->where('pasien_type', 'App\Models\Remaja')
                        ->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date])
                        ->with(['pemeriksaan', 'konsultasi'])
                        ->get();
                        
                    foreach ($data as $item) {
                        $item->pasien_nama = $remaja->nama_lengkap;
                        $riwayat->push($item);
                    }
                }
                break;
                
            case 'lansia':
                $lansia = Lansia::where('nik', $user->nik)->first();
                if ($lansia) {
                    $data = Kunjungan::where('pasien_id', $lansia->id)
                        ->where('pasien_type', 'App\Models\Lansia')
                        ->whereBetween('tanggal_kunjungan', [$request->start_date, $request->end_date])
                        ->with(['pemeriksaan', 'konsultasi'])
                        ->get();
                        
                    foreach ($data as $item) {
                        $item->pasien_nama = $lansia->nama_lengkap;
                        $riwayat->push($item);
                    }
                }
                break;
        }
        
        // Generate PDF (butuh package dompdf)
        // $pdf = PDF::loadView('user.riwayat.export', compact('riwayat', 'request'));
        // return $pdf->download('riwayat-kesehatan-' . date('Y-m-d') . '.pdf');
        
        return view('user.riwayat.export', compact('riwayat', 'request'));
    }
}