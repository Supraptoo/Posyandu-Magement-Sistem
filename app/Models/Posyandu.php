<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_posyandu',
        'kode_posyandu',
        'alamat',
        'telepon',
        'email',
        'kepala_posyandu',
        'jam_operasional',
        'latitude',
        'longitude',
        'status',
    ];

    public function kaders()
    {
        return $this->hasMany(Kader::class);
    }

    public function kunjungans()
    {
        return $this->hasManyThrough(Kunjungan::class, Kader::class, 'posyandu_id', 'petugas_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}