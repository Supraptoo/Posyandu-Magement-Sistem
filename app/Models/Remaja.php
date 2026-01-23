<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remaja extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_remaja',
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'sekolah',
        'kelas',
        'nama_ortu',
        'telepon_ortu',
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

    public function konselingRemaja()
    {
        return $this->hasMany(KonselingRemaja::class);
    }

    public function pemeriksaans()
    {
        return $this->hasManyThrough(Pemeriksaan::class, Kunjungan::class, 'pasien_id', 'kunjungan_id')
            ->where('pasien_type', Remaja::class);
    }

    public function analisisPemeriksaan()
    {
        return $this->hasMany(AnalisisPemeriksaanRemaja::class);
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

    public function getKategoriUsiaAttribute()
    {
        $usia = $this->usia;
        if ($usia >= 10 && $usia <= 14) {
            return 'Remaja Awal';
        } elseif ($usia >= 15 && $usia <= 19) {
            return 'Remaja Akhir';
        }
        
        return 'Di Luar Rentang Remaja';
    }
}