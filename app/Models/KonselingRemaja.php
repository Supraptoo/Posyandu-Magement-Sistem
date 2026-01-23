<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonselingRemaja extends Model
{
    use HasFactory;

    protected $table = 'konseling_remaja';

    protected $fillable = [
        'remaja_id',
        'bidan_id',
        'tanggal_konseling',
        'topik_konseling',
        'keluhan',
        'hasil_assessment',
        'rencana_tindakan',
        'rekomendasi',
        'jadwal_tindak_lanjut',
        'konsultasi_id',
    ];

    protected $casts = [
        'tanggal_konseling' => 'date',
        'jadwal_tindak_lanjut' => 'date',
    ];

    public function remaja()
    {
        return $this->belongsTo(Remaja::class);
    }

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }
}