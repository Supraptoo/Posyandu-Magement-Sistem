<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPosyandu extends Model
{
    use HasFactory;

    protected $table = 'jadwal_posyandu';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'kategori',
        'target_peserta',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope untuk filter
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeMendatang($query)
    {
        return $query->where('tanggal', '>=', now())
                    ->where('status', 'aktif');
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
    }

    // Accessor
    public function getFullWaktuAttribute()
    {
        return $this->waktu_mulai . ' - ' . $this->waktu_selesai;
    }

    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal->translatedFormat('d F Y');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'aktif' => '<span class="badge bg-success">Aktif</span>',
            'selesai' => '<span class="badge bg-secondary">Selesai</span>',
            'dibatalkan' => '<span class="badge bg-danger">Dibatalkan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getKategoriLabelAttribute()
    {
        return match($this->kategori) {
            'imunisasi' => 'Imunisasi',
            'pemeriksaan' => 'Pemeriksaan',
            'konseling' => 'Konseling',
            'posyandu' => 'Posyandu',
            'lainnya' => 'Lainnya',
            default => 'Unknown',
        };
    }

    public function getTargetPesertaLabelAttribute()
    {
        return match($this->target_peserta) {
            'semua' => 'Semua',
            'balita' => 'Balita',
            'remaja' => 'Remaja',
            'lansia' => 'Lansia',
            'ibu_hamil' => 'Ibu Hamil',
            default => 'Unknown',
        };
    }
}