<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format tanggal dengan penanganan null
     */
    public static function format($date, $format = 'd/m/Y', $default = '-')
    {
        // Jika null atau empty string
        if (empty($date)) {
            return $default;
        }
        
        // Jika sudah string yang diformat, return langsung
        if (is_string($date) && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            return $date;
        }
        
        try {
            // Jika string, parse dulu
            if (is_string($date)) {
                // Coba parse dengan Carbon
                $parsedDate = Carbon::parse($date);
                return $parsedDate->format($format);
            }
            
            // Jika Carbon atau DateTime object
            if ($date instanceof Carbon || $date instanceof \DateTime) {
                return $date->format($format);
            }
            
            // Default fallback
            return $default;
        } catch (\Exception $e) {
            // Log error untuk debugging (opsional)
            // \Log::warning('Date format error: ' . $e->getMessage());
            return $default;
        }
    }
    
    /**
     * Parse dan format tanggal
     */
    public static function parseAndFormat($dateString, $format = 'd/m/Y')
    {
        return self::format($dateString, $format);
    }
    
    /**
     * Cek apakah tanggal valid
     */
    public static function isValidDate($date)
    {
        if (empty($date)) {
            return false;
        }
        
        try {
            if (is_string($date)) {
                Carbon::parse($date);
                return true;
            }
            
            return ($date instanceof Carbon || $date instanceof \DateTime);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Hitung usia dari tanggal lahir
     */
    public static function calculateAge($birthDate)
    {
        if (!self::isValidDate($birthDate)) {
            return [
                'tahun' => 0,
                'bulan' => 0,
                'hari' => 0,
                'bulan_total' => 0
            ];
        }
        
        try {
            if (is_string($birthDate)) {
                $birthDate = Carbon::parse($birthDate);
            }
            
            $now = Carbon::now();
            $usia = $birthDate->diff($now);
            
            return [
                'tahun' => $usia->y,
                'bulan' => $usia->m,
                'hari' => $usia->d,
                'bulan_total' => $birthDate->diffInMonths($now)
            ];
        } catch (\Exception $e) {
            return [
                'tahun' => 0,
                'bulan' => 0,
                'hari' => 0,
                'bulan_total' => 0
            ];
        }
    }
    
    /**
     * Format usia untuk display
     */
    public static function formatAge($birthDate)
    {
        $age = self::calculateAge($birthDate);
        
        if ($age['tahun'] > 0) {
            return $age['tahun'] . ' tahun ' . $age['bulan'] . ' bulan';
        } elseif ($age['bulan'] > 0) {
            return $age['bulan'] . ' bulan ' . $age['hari'] . ' hari';
        } else {
            return $age['hari'] . ' hari';
        }
    }
}