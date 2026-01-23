<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('login_logs')) {
            Schema::create('login_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamp('login_at')->useCurrent();
                $table->enum('status', ['success', 'failed'])->default('success');
                $table->string('failure_reason')->nullable();
                $table->timestamps();
                
                // Indexes
                $table->index('user_id');
                $table->index('login_at');
                $table->index('status');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('login_logs');
    }
};