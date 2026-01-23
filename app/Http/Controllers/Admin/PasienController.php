<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Remaja;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PasienController extends Controller
{
    // ===== BALITA =====
    public function balitaIndex(Request $request)
    {
        $search = $request->get('search');
        
        $balitas = Balita::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kode_balita', 'like', "%{$search}%");
            })
            ->with('creator')
            ->latest()
            ->paginate(10);
            
        return view('admin.pasien.balita.index', compact('balitas', 'search'));
    }

    public function balitaCreate()
    {
        return view('admin.pasien.balita.create');
    }

    public function balitaStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|unique:balitas,nik|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
        ]);

        $kode = 'BLT-' . date('Ym') . str_pad(Balita::count() + 1, 3, '0', STR_PAD_LEFT);

        Balita::create([
            'kode_balita' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'alamat' => $request->alamat,
            'berat_lahir' => $request->berat_lahir,
            'panjang_lahir' => $request->panjang_lahir,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.pasien.balita.index')
            ->with('success', 'Data balita berhasil ditambahkan. Kode: ' . $kode);
    }

    public function balitaShow($id)
    {
        $balita = Balita::with(['kunjungans', 'creator'])->findOrFail($id);
        return view('admin.pasien.balita.show', compact('balita'));
    }

    public function balitaEdit($id)
    {
        $balita = Balita::findOrFail($id);
        return view('admin.pasien.balita.edit', compact('balita'));
    }

    public function balitaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|max:16|unique:balitas,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat' => 'required|string',
        ]);

        $balita = Balita::findOrFail($id);
        $balita->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'alamat' => $request->alamat,
            'berat_lahir' => $request->berat_lahir,
            'panjang_lahir' => $request->panjang_lahir,
        ]);

        return redirect()->route('admin.pasien.balita.show', $id)
            ->with('success', 'Data balita berhasil diperbarui');
    }

    public function balitaDestroy($id)
    {
        $balita = Balita::findOrFail($id);
        $balita->delete();

        return redirect()->route('admin.pasien.balita.index')
            ->with('success', 'Data balita berhasil dihapus');
    }

    // ===== REMAJA =====
    public function remajaIndex(Request $request)
    {
        $search = $request->get('search');
        
        $remajas = Remaja::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kode_remaja', 'like', "%{$search}%");
            })
            ->with('creator')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_remaja' => Remaja::count(),
            'laki_laki' => Remaja::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Remaja::where('jenis_kelamin', 'P')->count(),
            'kunjungan' => 0, // Bisa ditambahkan logika kunjungan jika ada
        ];

        return view('admin.pasien.remaja.index', compact('remajas', 'stats', 'search'));
    }

    public function remajaCreate()
    {
        return view('admin.pasien.remaja.create');
    }

    public function remajaStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|unique:remajas,nik|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'nama_ortu' => 'nullable|string|max:255',
            'telepon_ortu' => 'nullable|string|max:20',
        ]);

        $kode = 'RMJ-' . date('Ym') . str_pad(Remaja::count() + 1, 3, '0', STR_PAD_LEFT);

        Remaja::create([
            'kode_remaja' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'sekolah' => $request->sekolah,
            'kelas' => $request->kelas,
            'nama_ortu' => $request->nama_ortu,
            'telepon_ortu' => $request->telepon_ortu,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.pasien.remaja.index')
            ->with('success', 'Data remaja berhasil ditambahkan. Kode: ' . $kode);
    }

    public function remajaShow($id)
    {
        $remaja = Remaja::with(['kunjungans', 'creator'])->findOrFail($id);
        return view('admin.pasien.remaja.show', compact('remaja'));
    }

    public function remajaEdit($id)
    {
        $remaja = Remaja::findOrFail($id);
        return view('admin.pasien.remaja.edit', compact('remaja'));
    }

    public function remajaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|max:16|unique:remajas,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
        ]);

        $remaja = Remaja::findOrFail($id);
        $remaja->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'sekolah' => $request->sekolah,
            'kelas' => $request->kelas,
            'nama_ortu' => $request->nama_ortu,
            'telepon_ortu' => $request->telepon_ortu,
        ]);

        return redirect()->route('admin.pasien.remaja.show', $id)
            ->with('success', 'Data remaja berhasil diperbarui');
    }

    public function remajaDestroy($id)
    {
        $remaja = Remaja::findOrFail($id);
        $remaja->delete();

        return redirect()->route('admin.pasien.remaja.index')
            ->with('success', 'Data remaja berhasil dihapus');
    }

    // ===== LANSIA =====
    public function lansiaIndex(Request $request)
    {
        $search = $request->get('search');
        
        $lansias = Lansia::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('kode_lansia', 'like', "%{$search}%");
            })
            ->with('creator')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_lansia' => Lansia::count(),
            'laki_laki' => Lansia::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Lansia::where('jenis_kelamin', 'P')->count(),
            'kunjungan' => 0, // Bisa ditambahkan logika kunjungan jika ada
        ];

        return view('admin.pasien.lansia.index', compact('lansias', 'stats', 'search'));
    }

    public function lansiaCreate()
    {
        return view('admin.pasien.lansia.create');
    }

    public function lansiaStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|unique:lansias,nik|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:-60 years',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'penyakit_bawaan' => 'nullable|string',
        ]);

        $kode = 'LNS-' . date('Ym') . str_pad(Lansia::count() + 1, 3, '0', STR_PAD_LEFT);

        Lansia::create([
            'kode_lansia' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'penyakit_bawaan' => $request->penyakit_bawaan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.pasien.lansia.index')
            ->with('success', 'Data lansia berhasil ditambahkan. Kode: ' . $kode);
    }

    public function lansiaShow($id)
    {
        $lansia = Lansia::with(['kunjungans', 'creator'])->findOrFail($id);
        return view('admin.pasien.lansia.show', compact('lansia'));
    }

    public function lansiaEdit($id)
    {
        $lansia = Lansia::findOrFail($id);
        return view('admin.pasien.lansia.edit', compact('lansia'));
    }

    public function lansiaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|max:16|unique:lansias,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:-60 years',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
        ]);

        $lansia = Lansia::findOrFail($id);
        $lansia->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'penyakit_bawaan' => $request->penyakit_bawaan,
        ]);

        return redirect()->route('admin.pasien.lansia.show', $id)
            ->with('success', 'Data lansia berhasil diperbarui');
    }

    public function lansiaDestroy($id)
    {
        $lansia = Lansia::findOrFail($id);
        $lansia->delete();

        return redirect()->route('admin.pasien.lansia.index')
            ->with('success', 'Data lansia berhasil dihapus');
    }
}