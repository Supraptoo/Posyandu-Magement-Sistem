<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BalitaController extends Controller
{
    /**
     * Menampilkan daftar data balita
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $balitas = Balita::query()
            ->with(['user'])
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nama_ibu', 'like', "%{$search}%")
                    ->orWhere('nik_ibu', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);
            
        return view('kader.data.balita.index', compact('balitas', 'search'));
    }

    /**
     * Form tambah data balita
     */
    public function create()
    {
        return view('kader.data.balita.create');
    }

    /**
     * Simpan data balita baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'nullable|numeric|digits:16|unique:balitas,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'nik_ibu'       => 'required|numeric|digits:16',
            'nama_ibu'      => 'required|string|max:255',
            'nik_ayah'      => 'nullable|numeric|digits:16',
            'nama_ayah'     => 'nullable|string|max:255',
            'alamat'        => 'required|string',
            'berat_lahir'   => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1. Cari user berdasarkan NIK Ibu
            $linkedUser = $this->findUserByNik($request->nik_ibu);
            
            // 2. Generate Kode Unik Balita
            $kode = 'BLT-' . date('ym') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // 3. Simpan Data
            $balita = Balita::create([
                'user_id'       => $linkedUser ? $linkedUser->id : null,
                'kode_balita'   => $kode,
                'nik'           => $request->nik,
                'nama_lengkap'  => $request->nama_lengkap,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nik_ibu'       => $request->nik_ibu,
                'nama_ibu'      => $request->nama_ibu,
                'nik_ayah'      => $request->nik_ayah,
                'nama_ayah'     => $request->nama_ayah,
                'alamat'        => $request->alamat,
                'berat_lahir'   => $request->berat_lahir,
                'panjang_lahir' => $request->panjang_lahir,
                'created_by'    => Auth::id(),
            ]);

            DB::commit();
            
            $message = 'Data balita berhasil ditambahkan.';
            if ($linkedUser) {
                $message .= ' Terintegrasi dengan akun: ' . $linkedUser->name;
            } else {
                $message .= ' (Tidak ditemukan akun dengan NIK ini. Warga perlu daftar dengan NIK yang sama)';
            }
            
            return redirect()->route('kader.data.balita.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan balita: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Detail data balita
     */
    public function show($id) 
    {
        $balita = Balita::with(['kunjungans' => function($q) {
                $q->with(['petugas', 'pemeriksaan'])
                  ->latest()
                  ->take(10);
            }, 'user'])
            ->findOrFail($id);
        
        // Hitung usia detail
        $tgl_lahir = Carbon::parse($balita->tanggal_lahir);
        $diff = $tgl_lahir->diff(now());
        $usia_tahun = $diff->y;
        $usia_bulan = $diff->m;
        $usia_hari = $diff->d;
        $sisa_bulan = $usia_bulan; // untuk konsistensi dengan view

        // Cek apakah ada user yang terhubung
        $userTerhubung = $balita->user;
        if (!$userTerhubung && $balita->nik_ibu) {
            $userTerhubung = $this->findUserByNik($balita->nik_ibu);
        }

        return view('kader.data.balita.show', compact('balita', 'usia_tahun', 'usia_bulan', 'usia_hari', 'sisa_bulan', 'userTerhubung'));
    }

    /**
     * Form edit data balita
     */
    public function edit($id)
    {
        $balita = Balita::findOrFail($id);
        return view('kader.data.balita.edit', compact('balita'));
    }

    /**
     * Update data balita
     */
    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);
            
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'nullable|numeric|digits:16|unique:balitas,nik,' . $id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'nik_ibu'       => 'required|numeric|digits:16',
            'nama_ibu'      => 'required|string|max:255',
            'nik_ayah'      => 'nullable|numeric|digits:16',
            'nama_ayah'     => 'nullable|string|max:255',
            'alamat'        => 'required|string',
            'berat_lahir'   => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
        ]);

        try {
            // Cek ulang link user jika NIK Ibu berubah
            $linkedUser = null;
            if ($request->nik_ibu != $balita->nik_ibu) {
                $linkedUser = $this->findUserByNik($request->nik_ibu);
            }

            $balita->update([
                'user_id'       => $linkedUser ? $linkedUser->id : $balita->user_id,
                'nik'           => $request->nik,
                'nama_lengkap'  => $request->nama_lengkap,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nik_ibu'       => $request->nik_ibu,
                'nama_ibu'      => $request->nama_ibu,
                'nik_ayah'      => $request->nik_ayah,
                'nama_ayah'     => $request->nama_ayah,
                'alamat'        => $request->alamat,
                'berat_lahir'   => $request->berat_lahir,
                'panjang_lahir' => $request->panjang_lahir,
            ]);

            return redirect()->route('kader.data.balita.show', $id)
                ->with('success', 'Data balita berhasil diperbarui.');
                
        } catch (\Exception $e) {
            Log::error('Gagal update balita: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data balita
     */
    public function destroy($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Cek apakah ada kunjungan terkait
        if ($balita->kunjungans()->count() > 0) {
            return back()->with('error', 'Gagal hapus: Balita ini memiliki riwayat pemeriksaan. Hapus data kunjungan terlebih dahulu.');
        }
            
        $balita->delete();
        return redirect()->route('kader.data.balita.index')->with('success', 'Data balita berhasil dihapus.');
    }

    /**
     * Fungsi untuk sinkronisasi manual
     */
    public function syncUser($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Cari user berdasarkan NIK Ibu
        $user = $this->findUserByNik($balita->nik_ibu);
        
        if ($user) {
            $balita->update(['user_id' => $user->id]);
            return back()->with('success', 'Berhasil sinkronisasi dengan akun: ' . $user->name . ' (' . $user->email . ')');
        } else {
            return back()->with('error', 'Tidak ditemukan akun user dengan NIK: ' . $balita->nik_ibu);
        }
    }

    /**
     * Helper untuk mencari user berdasarkan NIK
     */
    private function findUserByNik($nik)
    {
        if (empty($nik)) return null;
        
        // Cari di tabel users
        $user = User::where('nik', $nik)->first();
        if ($user) return $user;
        
        // Cari di tabel profiles
        $profile = Profile::where('nik', $nik)->first();
        if ($profile) return $profile->user;
        
        return null;
    }
}