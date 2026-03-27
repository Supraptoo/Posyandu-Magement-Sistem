<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notifikasi; // Memastikan kita memakai model database yang benar

class NotifikasiController extends Controller
{
    /**
     * Halaman Utama Kotak Masuk Warga
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $filter = $request->get('filter', 'semua');

        try {
            // Kita wajib pakai Notifikasi karena broadcast Bidan masuk ke sini
            $query = Notifikasi::where('user_id', $user->id)->latest();

            if ($filter === 'belum') {
                $query->where('is_read', false);
            } elseif ($filter === 'sudah') {
                $query->where('is_read', true);
            }

            // PENTING: Variabel harus bernama $notifikasis (pakai 's') agar View tidak error
            $notifikasis = $query->paginate(15)->withQueryString();

            return view('user.notifikasi.index', compact('notifikasis', 'filter'));

        } catch (\Throwable $e) {
            Log::warning('NotifikasiController::index error: ' . $e->getMessage());
            $notifikasis = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
            return view('user.notifikasi.index', compact('notifikasis', 'filter'))->with('error', 'Gagal memuat pesan.');
        }
    }

    /**
     * AJAX Endpoint — Polling setiap N detik dari JS
     * (Hanya mengirimkan angka jumlah pesan baru agar server super ringan)
     */
    public function fetchRecent()
    {
        try {
            $unreadCount = Notifikasi::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return response()->json([
                'unreadCount' => $unreadCount
            ]);
        } catch (\Throwable $e) {
            return response()->json(['unreadCount' => 0]);
        }
    }

    /**
     * Tandai satu notifikasi sudah dibaca
     */
    public function markRead(Request $request, $id)
    {
        try {
            $notif = Notifikasi::where('user_id', Auth::id())->findOrFail($id);
            $notif->update(['is_read' => true]);

        } catch (\Throwable $e) {
            Log::warning('NotifikasiController::markRead error: ' . $e->getMessage());
        }

        return back();
    }

    /**
     * Tandai SEMUA notifikasi sudah dibaca (Sapu Bersih)
     */
    public function markAllRead()
    {
        try {
            Notifikasi::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
                
        } catch (\Throwable $e) {
            Log::warning('NotifikasiController::markAllRead error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses permintaan.');
        }

        return back()->with('success', 'Semua pesan telah ditandai dibaca.');
    }
}