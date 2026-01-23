<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotifikasiUser extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_user';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe',
        'dibaca',
        'link',
        'created_by',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope
    public function scopeBelumDibaca($query)
    {
        return $query->where('dibaca', false);
    }

    public function scopeSudahDibaca($query)
    {
        return $query->where('dibaca', true);
    }

    // Accessor
    public function getTipeLabelAttribute()
    {
        return match($this->tipe) {
            'jadwal' => 'Jadwal',
            'imunisasi' => 'Imunisasi',
            'pemeriksaan' => 'Pemeriksaan',
            'info' => 'Info',
            'pengumuman' => 'Pengumuman',
            default => 'Unknown',
        };
    }

    public function getTipeIconAttribute()
    {
        return match($this->tipe) {
            'jadwal' => 'fas fa-calendar',
            'imunisasi' => 'fas fa-syringe',
            'pemeriksaan' => 'fas fa-stethoscope',
            'info' => 'fas fa-info-circle',
            'pengumuman' => 'fas fa-bullhorn',
            default => 'fas fa-bell',
        };
    }

    public function getTipeColorAttribute()
    {
        return match($this->tipe) {
            'jadwal' => 'primary',
            'imunisasi' => 'success',
            'pemeriksaan' => 'info',
            'info' => 'warning',
            'pengumuman' => 'danger',
            default => 'secondary',
        };
    }
}