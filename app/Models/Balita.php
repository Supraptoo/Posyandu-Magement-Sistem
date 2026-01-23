<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_balita',
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ibu',
        'nama_ayah',
        'alamat',
        'berat_lahir',
        'panjang_lahir',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_lahir' => 'decimal:2',
        'panjang_lahir' => 'decimal:2',
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
            ->where('pasien_type', Balita::class);
    }

    public function getUsiaAttribute()
    {
        return now()->diffInMonths($this->tanggal_lahir);
    }

    public function getUsiaTahunAttribute()
    {
        return now()->diffInYears($this->tanggal_lahir);
    }

    public function getUsiaBulanAttribute()
    {
        return now()->diffInMonths($this->tanggal_lahir) % 12;
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
}