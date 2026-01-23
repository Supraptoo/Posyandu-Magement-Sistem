<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            
            // Kode Kunjungan (misal: KNJ-20231001-001)
            $table->string('kode_kunjungan')->unique()->nullable();
            
            // Relasi Polimorfik (Karena pasien bisa Balita, Remaja, atau Lansia)
            // Ini akan membuat 2 kolom: pasien_id (int) dan pasien_type (string)
            $table->unsignedBigInteger('pasien_id');
            $table->string('pasien_type');
            
            // Petugas yang menangani (Kader/Bidan) -> INI PENYEBAB ERRORNYA
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            
            // Detail Kunjungan
            $table->date('tanggal_kunjungan');
            $table->enum('jenis_kunjungan', ['umum', 'imunisasi', 'pemeriksaan', 'konsultasi', 'darurat'])->default('umum');
            $table->text('keluhan')->nullable();
            
            $table->timestamps();
            
            // Index untuk mempercepat pencarian
            $table->index(['pasien_id', 'pasien_type']);
            $table->index('tanggal_kunjungan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};