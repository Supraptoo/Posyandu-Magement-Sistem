<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pemeriksaan;
use App\Models\Kunjungan;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'semua');
        $search   = $request->get('search', '');
        $status   = $request->get('status', '');

        $query = Pemeriksaan::latest('tanggal_periksa');

        if ($kategori !== 'semua') $query->where('kategori_pasien', $kategori);
        if ($status) $query->where('status_verifikasi', $status);

        if ($search) {
            $balitaIds = Balita::where('nama_lengkap', 'like', "%$search%")->pluck('id');
            $remajaIds = Remaja::where('nama_lengkap', 'like', "%$search%")->pluck('id');
            $lansiaIds = Lansia::where('nama_lengkap', 'like', "%$search%")->pluck('id');
            
            $query->where(function($q) use($balitaIds, $remajaIds, $lansiaIds){
                $q->where(fn($q2)=>$q2->where('kategori_pasien','balita')->whereIn('pasien_id', $balitaIds))
                  ->orWhere(fn($q2)=>$q2->where('kategori_pasien','remaja')->whereIn('pasien_id', $remajaIds))
                  ->orWhere(fn($q2)=>$q2->where('kategori_pasien','lansia')->whereIn('pasien_id', $lansiaIds));
            });
        }

        $pemeriksaans = $query->paginate(15)->withQueryString();

        foreach ($pemeriksaans as $p) {
            $p->nama_pasien = $this->getNamaPasien($p->pasien_id, $p->kategori_pasien);
        }

        $stats = [
            'total'    => Pemeriksaan::count(),
            'pending'  => Pemeriksaan::where('status_verifikasi', 'pending')->count(),
            'verified' => Pemeriksaan::where('status_verifikasi', 'verified')->count(),
            'hari_ini' => Pemeriksaan::whereDate('tanggal_periksa', today())->count(),
        ];

        return view('kader.pemeriksaan.index', compact('pemeriksaans', 'kategori', 'search', 'status', 'stats'));
    }

    public function create(Request $request)
    {
        // Menyiapkan data JSON untuk Form Dinamis Real-Time
        $balitas = Balita::select('id', 'nama_lengkap', 'nik', 'kode_balita')->get()
            ->map(fn($item) => [
                'id' => $item->id, 
                'nama' => $item->nama_lengkap, 
                'nik' => $item->nik ?? $item->kode_balita,
                'kategori' => 'balita'
            ]);

        $remajas = Remaja::select('id', 'nama_lengkap', 'nik')->get()
            ->map(fn($item) => [
                'id' => $item->id, 
                'nama' => $item->nama_lengkap, 
                'nik' => $item->nik,
                'kategori' => 'remaja'
            ]);

        $lansias = Lansia::select('id', 'nama_lengkap', 'nik')->get()
            ->map(fn($item) => [
                'id' => $item->id, 
                'nama' => $item->nama_lengkap, 
                'nik' => $item->nik,
                'kategori' => 'lansia'
            ]);

        // Menggabungkan semua data pasien untuk disalurkan ke Frontend JS
        $semuaPasien = collect()->concat($balitas)->concat($remajas)->concat($lansias)->toArray();

        return view('kader.pemeriksaan.create', compact('semuaPasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_pasien' => 'required|in:balita,remaja,lansia',
            'pasien_id'       => 'required|integer',
            'tanggal_periksa' => 'required|date',
            'berat_badan'     => 'required|numeric|min:0.1|max:300',
            'tinggi_badan'    => 'required|numeric|min:1|max:250',
            'tekanan_darah'   => 'nullable|string|max:20',
            'suhu_tubuh'      => 'nullable|numeric|min:30|max:45',
            'lingkar_kepala'  => 'nullable|numeric',
            'lingkar_lengan'  => 'nullable|numeric',
            'lingkar_perut'   => 'nullable|numeric', // Tambahan untuk Remaja
            'hemoglobin'      => 'nullable|numeric', // Tambahan untuk Remaja
            'gula_darah'      => 'nullable|string|max:50',
            'kolesterol'      => 'nullable|integer',
            'asam_urat'       => 'nullable|numeric',
            'keluhan'         => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function() use($request){
                $pasienType = match($request->kategori_pasien){
                    'remaja' => 'App\\Models\\Remaja',
                    'lansia' => 'App\\Models\\Lansia',
                    default  => 'App\\Models\\Balita',
                };

                // Buat data riwayat kunjungan
                $kunjungan = Kunjungan::create([
                    'kode_kunjungan'    => $this->generateKode(),
                    'pasien_id'         => $request->pasien_id,
                    'pasien_type'       => $pasienType,
                    'tanggal_kunjungan' => $request->tanggal_periksa,
                    'jenis_kunjungan'   => 'pemeriksaan',
                    'keluhan'           => $request->keluhan,
                    'petugas_id'        => auth()->id(),
                ]);

                // Simpan detail pengukuran ke tabel Pemeriksaan
                Pemeriksaan::create([
                    'kunjungan_id'      => $kunjungan->id,
                    'pasien_id'         => $request->pasien_id,
                    'kategori_pasien'   => $request->kategori_pasien,
                    'pemeriksa_id'      => auth()->id(),
                    'user_id'           => auth()->id(), // Mencatat kader yang menginput
                    'tanggal_periksa'   => $request->tanggal_periksa,
                    'berat_badan'       => $request->berat_badan,
                    'tinggi_badan'      => $request->tinggi_badan,
                    'lingkar_kepala'    => $request->lingkar_kepala,
                    'lingkar_lengan'    => $request->lingkar_lengan,
                    'lingkar_perut'     => $request->lingkar_perut, // Disimpan
                    'suhu_tubuh'        => $request->suhu_tubuh,
                    'tekanan_darah'     => $request->tekanan_darah,
                    'hemoglobin'        => $request->hemoglobin,    // Disimpan
                    'gula_darah'        => $request->gula_darah,
                    'kolesterol'        => $request->kolesterol,
                    'asam_urat'         => $request->asam_urat,
                    'keluhan'           => $request->keluhan,
                    'status_verifikasi' => 'pending', // Menunggu validasi bidan
                ]);
            });

            return redirect()->route('kader.pemeriksaan.index')
                ->with('success','✅ Pemeriksaan berhasil disimpan. Menunggu verifikasi bidan.');

        } catch(\Throwable $e){
            Log::error('KaderPemeriksaan::store — '.$e->getMessage());
            return back()->withInput()->with('error','Gagal menyimpan: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $p = Pemeriksaan::findOrFail($id);
        $p->nama_pasien = $this->getNamaPasien($p->pasien_id, $p->kategori_pasien);
        $p->data_pasien = $this->getDataPasien($p->pasien_id, $p->kategori_pasien);
        
        return view('kader.pemeriksaan.show', ['pemeriksaan' => $p]);
    }

    public function edit($id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        
        // Jika sudah diverifikasi bidan, kader tidak boleh mengubah data
        if ($pemeriksaan->status_verifikasi !== 'pending') {
            return back()->with('error','Pemeriksaan sudah diverifikasi, tidak bisa diedit.');
        }

        return view('kader.pemeriksaan.edit', compact('pemeriksaan'));
    }

    public function update(Request $request, $id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        
        if ($pemeriksaan->status_verifikasi !== 'pending') {
            return back()->with('error','Tidak bisa mengubah pemeriksaan yang sudah diverifikasi.');
        }

        $request->validate([
            'tanggal_periksa' => 'required|date',
            'berat_badan'     => 'required|numeric|min:0.1|max:300',
            'tinggi_badan'    => 'required|numeric|min:1|max:250',
            'lingkar_perut'   => 'nullable|numeric',
            'hemoglobin'      => 'nullable|numeric',
        ]);

        try {
            DB::transaction(function() use ($request, $pemeriksaan) {
                // Update tabel Pemeriksaan
                $pemeriksaan->update($request->only([
                    'tanggal_periksa', 'berat_badan', 'tinggi_badan', 'lingkar_kepala',
                    'lingkar_lengan', 'lingkar_perut', 'suhu_tubuh', 'tekanan_darah', 'hemoglobin',
                    'gula_darah', 'kolesterol', 'asam_urat', 'keluhan'
                ]));

                // Sesuaikan juga tanggal di tabel Kunjungan jika diubah
                if ($pemeriksaan->kunjungan_id) {
                    Kunjungan::find($pemeriksaan->kunjungan_id)?->update([
                        'tanggal_kunjungan' => $request->tanggal_periksa,
                        'keluhan' => $request->keluhan
                    ]);
                }
            });

            return redirect()->route('kader.pemeriksaan.index')
                ->with('success','✅ Data pemeriksaan berhasil diperbarui.');
                
        } catch(\Throwable $e){
            return back()->withInput()->with('error','Gagal: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        
        if ($pemeriksaan->status_verifikasi !== 'pending') {
            return back()->with('error','Tidak bisa menghapus pemeriksaan yang sudah diverifikasi.');
        }

        try {
            DB::transaction(function() use($pemeriksaan){
                if ($pemeriksaan->kunjungan_id) {
                    Kunjungan::find($pemeriksaan->kunjungan_id)?->delete();
                }
                $pemeriksaan->delete();
            });
            return redirect()->route('kader.pemeriksaan.index')
                ->with('success','Data pemeriksaan berhasil dihapus.');
                
        } catch(\Throwable $e){
            return back()->with('error','Gagal menghapus: '.$e->getMessage());
        }
    }

    // ================= HELPERS =================
    
    private function getNamaPasien($pasienId, $kategori): string
    {
        try {
            return match($kategori){
                'remaja' => Remaja::find($pasienId)?->nama_lengkap ?? '-',
                'lansia' => Lansia::find($pasienId)?->nama_lengkap ?? '-',
                default  => Balita::find($pasienId)?->nama_lengkap ?? '-',
            };
        } catch(\Throwable $e){ return '-'; }
    }

    private function getDataPasien($pasienId, $kategori)
    {
        try {
            return match($kategori){
                'remaja' => Remaja::find($pasienId),
                'lansia' => Lansia::find($pasienId),
                default  => Balita::find($pasienId),
            };
        } catch(\Throwable $e){ return null; }
    }

    private function generateKode(): string
    {
        $prefix = 'KNJ-'.date('Ymd');
        $last   = Kunjungan::where('kode_kunjungan','like',"$prefix%")
            ->orderByDesc('id')->value('kode_kunjungan');
        $seq    = $last ? (intval(substr($last,-4))+1) : 1;
        return $prefix.str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}