<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    // Tabel yang benar berdasarkan database: notifikasis
    // (notifikasi_user adalah pivot table berbeda)
    protected $table = 'notifikasis';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope belum dibaca — pakai is_read (kolom yang ada di notifikasis)
    public function scopeBelumDibaca($query)
    {
        return $query->where('is_read', false);
    }
}