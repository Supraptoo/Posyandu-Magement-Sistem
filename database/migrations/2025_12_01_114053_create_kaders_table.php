<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kaders', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Khusus Kader
            $table->string('jabatan')->nullable(); // Contoh: Ketua, Sekretaris, Anggota
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('status_kader', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('wilayah_binaan')->nullable(); // Opsional
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kaders');
    }
};