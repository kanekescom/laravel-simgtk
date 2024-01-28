<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('simgtk.table_prefix') . 'rancangan_bezzeting', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('rencana_bezzeting_id')->index();
            $table->foreignUlid('sekolah_id')->index();
            $table->unsignedTinyInteger('jumlah_kelas')->nullable();
            $table->unsignedTinyInteger('jumlah_rombel')->nullable();
            $table->unsignedSmallInteger('jumlah_siswa')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix') . 'rancangan_bezzeting');
    }
};
