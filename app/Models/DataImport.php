<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_file',
        'jenis_data',
        'file_path',
        'status',
        'total_data',
        'data_berhasil',
        'data_gagal',
        'catatan',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'info',
            'processing' => 'warning',
            'completed' => 'success',
            'failed' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getJenisDataLabelAttribute()
    {
        $labels = [
            'balita' => 'Balita',
            'remaja' => 'Remaja',
            'lansia' => 'Lansia'
        ];

        return $labels[$this->jenis_data] ?? $this->jenis_data;
    }
}