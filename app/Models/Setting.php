<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    /**
     * Get all settings as key-value pairs
     */
    public static function getAll()
    {
        return Cache::remember('settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get setting by key
     */
    public static function get($key, $default = null)
    {
        $settings = self::getAll();
        return $settings[$key] ?? $default;
    }

    /**
     * Set setting value
     */
    public static function set($key, $value, $description = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description
            ]
        );

        // Clear cache setelah update
        Cache::forget('settings');

        return $setting;
    }

    /**
     * Set multiple settings at once
     */
    public static function setMany(array $settings)
    {
        foreach ($settings as $key => $value) {
            self::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear cache
        Cache::forget('settings');
    }

    /**
     * Get settings for display (dengan fallback)
     */
    public static function getAllWithDefaults()
    {
        $settings = self::getAll();
        
        $defaults = [
            'nama_posyandu' => 'Posyandu',
            'alamat_posyandu' => '',
            'telepon_posyandu' => '',
            'email_posyandu' => '',
            'kepala_posyandu' => '',
            'jam_operasional' => 'Senin-Jumat: 08:00-15:00',
        ];

        return array_merge($defaults, $settings);
    }
}