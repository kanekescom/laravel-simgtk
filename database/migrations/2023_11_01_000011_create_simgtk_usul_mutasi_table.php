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
        Schema::create(config('simgtk.table_prefix').'usul_mutasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('rencana_mutasi_id')->index('11_rencana_mutasi_id');
            $table->foreignUlid('pegawai_id')->index('11_pegawai_id');
            $table->foreignUlid('asal_sekolah_id')->index('11_asal_sekolah_id');
            $table->foreignUlid('asal_mata_pelajaran_id')->index('11_asal_mata_pelajaran_id');
            $table->foreignUlid('tujuan_sekolah_id')->index('11_tujuan_sekolah_id');
            $table->foreignUlid('tujuan_mata_pelajaran_id')->index('11_tujuan_mata_pelajaran_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix').'usul_mutasi');
    }
};
