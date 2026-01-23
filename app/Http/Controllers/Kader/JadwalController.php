<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\JadwalPosyandu;
use App\Models\NotifikasiUser;
use App\Models\User; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $jadwals = JadwalPosyandu::query()
            ->when($search, function($query) use ($search) {
                return $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
            
        return view('kader.jadwal.index', compact('jadwals', 'search', 'status'));
    }

    public function create()
    {
        return view('kader.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'kategori' => 'required|in:imunisasi,pemeriksaan,konseling,posyandu,lainnya',
            'target_peserta' => 'required|in:semua,balita,remaja,lansia,ibu_hamil',
        ]);
        
        $jadwal = JadwalPosyandu::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'kategori' => $request->kategori,
            'target_peserta' => $request->target_peserta,
            'status' => 'aktif',
            'created_by' => Auth::id(),
        ]);
        
        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function show($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        return view('kader.jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        return view('kader.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
            
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'kategori' => 'required|in:imunisasi,pemeriksaan,konseling,posyandu,lainnya',
            'target_peserta' => 'required|in:semua,balita,remaja,lansia,ibu_hamil',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);
        
        $jadwal->update($request->all());
        
        return redirect()->route('kader.jadwal.show', $id)
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        $jadwal->delete();
        
        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    public function broadcast($id)
{
    $jadwal = JadwalPosyandu::findOrFail($id);
    
    // Kirim notifikasi ke semua user sesuai target
    $users = User::where('role', 'user')
        ->where('status', 'active')
        ->get();
        
    foreach ($users as $user) {
        NotifikasiUser::create([
            'user_id' => $user->id,
            'judul' => 'Jadwal Posyandu: ' . $jadwal->judul,
            'pesan' => $jadwal->deskripsi . "\n\nTanggal: " . $jadwal->tanggal . 
                      "\nWaktu: " . $jadwal->waktu_mulai . " - " . $jadwal->waktu_selesai . 
                      "\nLokasi: " . $jadwal->lokasi,
            'tipe' => 'jadwal',
            'dibaca' => false,
            'created_by' => Auth::id(),
        ]);
    }
    
    return back()->with('success', 'Notifikasi jadwal berhasil dikirim ke ' . $users->count() . ' user');
}
}