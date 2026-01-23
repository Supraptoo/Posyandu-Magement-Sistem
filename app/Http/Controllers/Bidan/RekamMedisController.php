<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type', 'balita');
        
        $rekamMedis = collect();
        
        switch ($type) {
            case 'balita':
                $query = Balita::query();
                if ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('kode_balita', 'like', "%{$search}%");
                }
                $data = $query->paginate(10);
                break;
                
            case 'remaja':
                $query = Remaja::query();
                if ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('kode_remaja', 'like', "%{$search}%");
                }
                $data = $query->paginate(10);
                break;
                
            case 'lansia':
                $query = Lansia::query();
                if ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('kode_lansia', 'like', "%{$search}%");
                }
                $data = $query->paginate(10);
                break;
                
            default:
                $data = collect();
        }
        
        return view('bidan.rekam-medis.index', compact('data', 'type', 'search'));
    }

    public function show($pasien_type, $pasien_id)
    {
        $modelClass = $this->getModelClass($pasien_type);
        $pasien = $modelClass::findOrFail($pasien_id);
        
        $kunjungans = Kunjungan::where('pasien_id', $pasien_id)
            ->where('pasien_type', $modelClass)
            ->with(['pemeriksaan', 'imunisasis', 'vitamins', 'konsultasi'])
            ->latest()
            ->get();
            
        return view('bidan.rekam-medis.show', compact('pasien', 'kunjungans', 'pasien_type'));
    }

    private function getModelClass($type)
    {
        return match($type) {
            'balita' => 'App\Models\Balita',
            'remaja' => 'App\Models\Remaja',
            'lansia' => 'App\Models\Lansia',
            default => null,
        };
    }
}