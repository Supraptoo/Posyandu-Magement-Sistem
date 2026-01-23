<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_lansia',
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'penyakit_bawaan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kunjungans()
    {
        return $this->morphMany(Kunjungan::class, 'pasien');
    }

    public function pemeriksaans()
    {
        return $this->hasManyThrough(Pemeriksaan::class, Kunjungan::class, 'pasien_id', 'kunjungan_id')
            ->where('pasien_type', Lansia::class);
    }

    public function getUsiaAttribute()
    {
        return now()->diffInYears($this->tanggal_lahir);
    }

    public function scopeByNik($query, $nik)
    {
        return $query->where('nik', $nik);
    }

    public function scopeAktif($query)
    {
        return $query->whereHas('kunjungans', function($q) {
            $q->where('tanggal_kunjungan', '>=', now()->subYear());
        });
    }

    public function getStatusGiziAttribute()
    {
        $usia = $this->usia;
        // Logika penentuan status gizi untuk lansia
        if ($usia >= 60 && $usia <= 75) {
            return 'Lansia Muda';
        } elseif ($usia > 75) {
            return 'Lansia Tua';
        }
        
        return 'Pra-Lansia';
    }
}