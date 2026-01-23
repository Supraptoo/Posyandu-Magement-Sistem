<?php
?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiNilaiRemaja extends Model
{
    use HasFactory;

    protected $table = 'referensi_nilai_remaja';

    protected $fillable = [
        'jenis_pemeriksaan',
        'usia_tahun',
        'jenis_kelamin',
        'kategori',
        'nilai_min',
        'nilai_max',
        'satuan',
        'keterangan',
    ];

    // SCOPES
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_pemeriksaan', $jenis);
    }

    public function scopeUsia($query, $usia)
    {
        return $query->where('usia_tahun', $usia);
    }

    public function scopeJenisKelamin($query, $jk)
    {
        return $query->where('jenis_kelamin', $jk);
    }

    // METHODS
    public static function getKategori($jenis, $usia, $jk, $nilai)
    {
        return self::where('jenis_pemeriksaan', $jenis)
            ->where('usia_tahun', $usia)
            ->where('jenis_kelamin', $jk)
            ->where('nilai_min', '<=', $nilai)
            ->where('nilai_max', '>=', $nilai)
            ->first();
    }
}