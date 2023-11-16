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
        Schema::create(config('simgtk.table_prefix') . 'sekolah', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('npsn')->index('npsn');
            $table->string('jenjang_sekolah_id')->nullable()->index('jenjang_sekolah_id');
            $table->foreignUlid('provinsi_kode')->nullable()->index('provinsi_kode');
            $table->foreignUlid('kabupaten_kode')->nullable()->index('kabupaten_kode');
            $table->foreignUlid('kecamatan_kode')->nullable()->index('kecamatan_kode');
            $table->foreignUlid('desa_kode')->nullable()->index('desa_kode');
            $table->date('tanggal_aktif')->nullable();
            $table->date('tanggal_nonaktif')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix') . 'sekolah');
    }
};
