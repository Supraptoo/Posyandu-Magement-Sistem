<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'topik',
        'keluhan',
        'saran',
        'tindak_lanjut',
        'konsultan_id',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function konsultan()
    {
        return $this->belongsTo(User::class, 'konsultan_id');
    }

    public function konselingRemaja()
    {
        return $this->hasOne(KonselingRemaja::class);
    }
}