<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisPemeriksaanRemaja extends Model
{
    use HasFactory;

    protected $table = 'analisis_pemeriksaan_remaja';

    protected $fillable = [
        'pemeriksaan_id',
        'remaja_id',
        'usia_saat_periksa',
        'jenis_kelamin',
        'imt_nilai',
        'imt_kategori',
        'hemoglobin_nilai',
        'hemoglobin_kategori',
        'lila_nilai',
        'lila_kategori',
        'gula_darah_puasa_nilai',
        'gula_darah_2jam_nilai',
        'gula_darah_sewaktu_nilai',
        'gula_darah_kategori',
        'rekomendasi_umum',
        'rekomendasi_khusus',
        'status',
    ];

    protected $casts = [
        'imt_nilai' => 'decimal:2',
        'lila_nilai' => 'decimal:2',
        'hemoglobin_nilai' => 'decimal:2',
        'gula_darah_puasa_nilai' => 'decimal:2',
        'gula_darah_2jam_nilai' => 'decimal:2',
        'gula_darah_sewaktu_nilai' => 'decimal:2',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function remaja()
    {
        return $this->belongsTo(Remaja::class);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'normal' => 'Normal',
            'warning' => 'Perhatian',
            'danger' => 'Berisiko',
            'critical' => 'Kritis'
        ];
        
        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }
}