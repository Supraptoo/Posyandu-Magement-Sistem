<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\JadwalPosyandu; // Pastikan nama model Anda sesuai
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal posyandu (SPA feel)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'semua');

        $query = JadwalPosyandu::query()->latest('tanggal');

        // Filter Status
        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        // Filter Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $jadwals = $query->paginate(10)->withQueryString();

        return view('kader.jadwal.index', compact('jadwals', 'search', 'status'));
    }

    /**
     * Menampilkan form tambah jadwal
     */
    public function create()
    {
        return view('kader.jadwal.create');
    }

    /**
     * Menyimpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'target_peserta' => 'required|in:semua,balita,remaja,lansia',
            'kategori'       => 'required|string',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required',
            'waktu_selesai'  => 'required',
            'lokasi'         => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
        ]);

        JadwalPosyandu::create([
            'judul'          => $request->judul,
            'target_peserta' => $request->target_peserta,
            'kategori'       => $request->kategori,
            'tanggal'        => $request->tanggal,
            'waktu_mulai'    => $request->waktu_mulai,
            'waktu_selesai'  => $request->waktu_selesai,
            'lokasi'         => $request->lokasi,
            'deskripsi'      => $request->deskripsi,
            'status'         => 'aktif', // Status default saat baru dibuat
        ]);

        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan! Silakan cek detail untuk mem-broadcast pengumuman.');
    }

    /**
     * Menampilkan detail jadwal (Poster Digital)
     */
    public function show($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        return view('kader.jadwal.show', compact('jadwal'));
    }

    /**
     * Menampilkan form edit jadwal
     */
    public function edit($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        return view('kader.jadwal.edit', compact('jadwal'));
    }

    /**
     * Memperbarui jadwal
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);

        $request->validate([
            'judul'          => 'required|string|max:255',
            'target_peserta' => 'required|in:semua,balita,remaja,lansia',
            'kategori'       => 'required|string',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required',
            'waktu_selesai'  => 'required',
            'lokasi'         => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'status'         => 'required|in:aktif,selesai,dibatalkan'
        ]);

        $jadwal->update($request->all());

        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal
     */
    public function destroy($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * BROADCAST NOTIFIKASI KE WARGA
     */
    public function broadcast($id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);

        if ($jadwal->status !== 'aktif') {
            return back()->with('error', 'Hanya jadwal aktif yang bisa di-broadcast!');
        }

        try {
            DB::transaction(function() use ($jadwal) {
                // 1. Tentukan target user berdasarkan target_peserta
                $userIds = [];

                if ($jadwal->target_peserta == 'semua') {
                    // Ambil semua user dengan role 'user' (warga)
                    $userIds = User::whereHas('roles', function($q){
                        $q->where('name', 'user');
                    })->pluck('id')->toArray();
                } 
                else if ($jadwal->target_peserta == 'balita') {
                    // Ambil user yang punya relasi ke balita
                    $userIds = \App\Models\Balita::whereNotNull('user_id')->pluck('user_id')->toArray();
                }
                else if ($jadwal->target_peserta == 'remaja') {
                    // Ambil user yang punya relasi ke remaja
                    $userIds = \App\Models\Remaja::whereNotNull('user_id')->pluck('user_id')->toArray();
                }
                else if ($jadwal->target_peserta == 'lansia') {
                    // Ambil user yang punya relasi ke lansia
                    $userIds = \App\Models\Lansia::whereNotNull('user_id')->pluck('user_id')->toArray();
                }

                // Hapus duplikat ID jika 1 user punya 2 balita
                $userIds = array_unique($userIds);

                // 2. Buat Notifikasi Batch Insert untuk performa (RAD)
                $notifikasiData = [];
                $waktuSekarang = now();

                $pesan = "Pengumuman! Ada kegiatan {$jadwal->judul} pada tanggal " . \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') . " jam {$jadwal->waktu_mulai} di {$jadwal->lokasi}.";

                foreach ($userIds as $userId) {
                    $notifikasiData[] = [
                        'user_id'    => $userId,
                        'judul'      => 'Jadwal Posyandu Baru',
                        'pesan'      => $pesan,
                        'is_read'    => false, // Belum dibaca
                        'created_at' => $waktuSekarang,
                        'updated_at' => $waktuSekarang,
                    ];
                }

                // Insert massal ke database
                if (!empty($notifikasiData)) {
                    DB::table('notifikasis')->insert($notifikasiData); // Pastikan nama tabel Anda 'notifikasis'
                }
            });

            return redirect()->route('kader.jadwal.show', $id)
                ->with('success', '🎉 Broadcast berhasil! Notifikasi telah dikirim ke aplikasi warga terkait.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mem-broadcast notifikasi: ' . $e->getMessage());
        }
    }
}