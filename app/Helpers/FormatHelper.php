<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatHelper
{
    public static function formatUsiaBalita(Carbon $tanggal_lahir)
    {
        $usia_bulan = $tanggal_lahir->diffInMonths(now());
        $usia_tahun = floor($usia_bulan / 12);
        $sisa_bulan = $usia_bulan % 12;
        
        if ($usia_tahun > 0) {
            return $usia_tahun . ' thn ' . $sisa_bulan . ' bln';
        }
        
        return $sisa_bulan . ' bln';
    }
    
    public static function formatUsiaTahun(Carbon $tanggal_lahir)
    {
        return $tanggal_lahir->diffInYears(now()) . ' tahun';
    }
}