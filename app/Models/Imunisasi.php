<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'jenis_imunisasi',
        'vaksin',
        'dosis',
        'tanggal_imunisasi',
        'batch_number',
        'expiry_date',
        'penyelenggara',
    ];

    protected $casts = [
        'tanggal_imunisasi' => 'date',
        'expiry_date' => 'date',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}