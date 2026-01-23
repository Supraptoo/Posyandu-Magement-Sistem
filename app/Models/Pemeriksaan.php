<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'pemeriksa_id',
        'tinggi_badan',
        'berat_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'suhu_tubuh',
        'tekanan_darah',
        'denyut_nadi',
        'respirasi',
        'imt',
        'kategori_imt',
        'hemoglobin',
        'gula_darah',
        'kolesterol',
        'asam_urat',
        'keluhan',
        'diagnosa',
        'tindakan',
        'catatan',
        'rekomendasi',
    ];

    protected $casts = [
        'tinggi_badan' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'lingkar_lengan' => 'decimal:2',
        'suhu_tubuh' => 'decimal:1',
        'imt' => 'decimal:2',
        'hemoglobin' => 'decimal:2',
        'gula_darah' => 'decimal:2',
        'kolesterol' => 'decimal:2',
        'asam_urat' => 'decimal:2',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function pemeriksa()
    {
        return $this->belongsTo(User::class, 'pemeriksa_id');
    }

    public function analisisRemaja()
    {
        return $this->hasOne(AnalisisPemeriksaanRemaja::class);
    }

    public function getStatusGiziAttribute()
    {
        if (!$this->imt) return null;

        if ($this->imt < 18.5) {
            return 'Kurus';
        } elseif ($this->imt >= 18.5 && $this->imt <= 24.9) {
            return 'Normal';
        } elseif ($this->imt >= 25 && $this->imt <= 29.9) {
            return 'Gemuk';
        } else {
            return 'Obesitas';
        }
    }
}