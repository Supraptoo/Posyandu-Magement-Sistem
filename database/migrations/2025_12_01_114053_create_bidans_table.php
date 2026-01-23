<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bidans', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Khusus Bidan
            $table->string('jabatan')->default('Bidan Desa');
            $table->string('no_str')->nullable(); // Surat Tanda Registrasi
            $table->string('no_sip')->nullable(); // Surat Izin Praktik
            $table->string('lokasi_praktik')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidans');
    }
};