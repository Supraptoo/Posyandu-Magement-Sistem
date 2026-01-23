<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('imunisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');
            
            $table->string('jenis_imunisasi'); // BCG, Polio 1, dll
            $table->string('vaksin')->nullable(); // Nama vaksin spesifik
            $table->string('batch_number')->nullable(); // Nomor batch vaksin
            $table->date('tanggal_imunisasi');
            $table->text('catatan')->nullable(); // Reaksi KIPI dll
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imunisasis');
    }
};