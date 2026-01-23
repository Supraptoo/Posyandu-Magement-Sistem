<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateLaporan extends Model
{
    use HasFactory;

    protected $table = 'template_laporan';

    protected $fillable = [
        'nama_template',
        'jenis_laporan',
        'template_file',
        'format_output',
        'status',
        'created_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor
    public function getJenisLaporanLabelAttribute()
    {
        return match($this->jenis_laporan) {
            'balita' => 'Balita',
            'remaja' => 'Remaja',
            'lansia' => 'Lansia',
            'imunisasi' => 'Imunisasi',
            'kunjungan' => 'Kunjungan',
            'keseluruhan' => 'Keseluruhan',
            default => 'Unknown',
        };
    }

    public function getFormatOutputLabelAttribute()
    {
        return match($this->format_output) {
            'pdf' => 'PDF',
            'excel' => 'Excel',
            'word' => 'Word',
            default => 'Unknown',
        };
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == 'aktif' 
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-danger">Nonaktif</span>';
    }

    // Scope
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_laporan', $jenis);
    }
}