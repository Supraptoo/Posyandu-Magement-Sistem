<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vitamin extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'jenis_vitamin',
        'dosis',
        'tanggal_pemberian',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
        'dosis' => 'decimal:2',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function getJenisVitaminLabelAttribute()
    {
        $vitamins = [
            'a' => 'Vitamin A',
            'b' => 'Vitamin B Kompleks',
            'c' => 'Vitamin C',
            'd' => 'Vitamin D',
            'e' => 'Vitamin E',
            'zat_besi' => 'Zat Besi',
            'kalsium' => 'Kalsium'
        ];
        
        return $vitamins[$this->jenis_vitamin] ?? 'Vitamin Lainnya';
    }
}