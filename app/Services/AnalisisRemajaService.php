<?php
?php

namespace App\Services;

use App\Models\AnalisisPemeriksaanRemaja;
use App\Models\ReferensiNilaiRemaja;

class AnalisisRemajaService
{
    public function analisisIMT(\, \, \)
    {
        \ = ReferensiNilaiRemaja::where('jenis_pemeriksaan', 'imt')
            ->where('usia_tahun', \)
            ->where('jenis_kelamin', \)
            ->get();
        
        foreach (\ as \) {
            if (\->kategori == 'kurus' && \ <= \->nilai_max) {
                return [
                    'kategori' => 'kurus',
                    'pesan' => 'IMT menunjukkan status kurus. Perlu perbaikan gizi.',
                    'rekomendasi' => 'Tingkatkan asupan makanan bergizi, konsumsi makanan tinggi protein dan kalori.'
                ];
            } elseif (\->kategori == 'normal' && \ >= \->nilai_min && \ <= \->nilai_max) {
                return [
                    'kategori' => 'normal',
                    'pesan' => 'IMT dalam batas normal.',
                    'rekomendasi' => 'Pertahankan pola makan sehat dan aktivitas fisik.'
                ];
            } elseif (\->kategori == 'gemuk' && \ >= \->nilai_min) {
                return [
                    'kategori' => 'gemuk',
                    'pesan' => 'IMT menunjukkan status gemuk.',
                    'rekomendasi' => 'Perbanyak aktivitas fisik, kurangi makanan tinggi gula dan lemak.'
                ];
            }
        }
        
        return [
            'kategori' => 'tidak_terdefinisi',
            'pesan' => 'Data tidak sesuai referensi.',
            'rekomendasi' => 'Konsultasikan dengan bidan.'
        ];
    }
    
    public function analisisHemoglobin(\, \)
    {
        if (\ == 'L') {
            if (\ >= 14 && \ <= 18) {
                return ['kategori' => 'normal', 'pesan' => 'Hemoglobin normal'];
            } elseif (\ < 14) {
                return ['kategori' => 'rendah', 'pesan' => 'Hemoglobin rendah (anemia)'];
            } else {
                return ['kategori' => 'tinggi', 'pesan' => 'Hemoglobin tinggi'];
            }
        } else {
            if (\ >= 12 && \ <= 16) {
                return ['kategori' => 'normal', 'pesan' => 'Hemoglobin normal'];
            } elseif (\ < 12) {
                return ['kategori' => 'rendah', 'pesan' => 'Hemoglobin rendah (anemia)'];
            } else {
                return ['kategori' => 'tinggi', 'pesan' => 'Hemoglobin tinggi'];
            }
        }
    }
}
