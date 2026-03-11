<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type', 'balita');
        
        switch ($type) {
            case 'balita':
                $query = Balita::query();
                if ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                }
                $data = $query->paginate(10);
                break;
                
            case 'remaja':
                $query = Remaja::query();
                if ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                }
                $data = $query->paginate(10);
                break;
                
            case 'lansia':
                $query = Lansia::query();
                if ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
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
        // Mencari data identitas pasien
        $modelClass = $this->getModelClass($pasien_type);
        $pasien = $modelClass::findOrFail($pasien_id);
        
        // MENGATASI ERROR: Kita ambil riwayat dari tabel Pemeriksaan langsung
        // Karena tabel ini sudah pasti ada dan menyimpan history pasien.
        $kunjungans = Pemeriksaan::where('pasien_id', $pasien_id)
            ->where('kategori_pasien', $pasien_type)
            ->latest('tanggal_periksa')
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