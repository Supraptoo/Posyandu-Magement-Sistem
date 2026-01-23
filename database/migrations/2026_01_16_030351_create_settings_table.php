<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('text');
                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        } else {
            // Jika tabel sudah ada, tambahkan kolom yang mungkin kurang
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'type')) {
                    $table->string('type')->default('text')->after('value');
                }
                if (!Schema::hasColumn('settings', 'group')) {
                    $table->string('group')->default('general')->after('type');
                }
                if (!Schema::hasColumn('settings', 'description')) {
                    $table->text('description')->nullable()->after('group');
                }
            });
        }
    }

    public function down()
    {
        // Jangan drop table jika sudah ada data
        // Schema::dropIfExists('settings');
    }
};