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
        Schema::create(config('simgtk.table_prefix').'sekolah', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('npsn')->index();
            $table->foreignUlid('jenjang_sekolah_id')->nullable()->index();
            $table->string('wilayah_kode')->nullable()->index();
            $table->unsignedTinyInteger('jumlah_kelas')->nullable();
            $table->unsignedTinyInteger('jumlah_rombel')->nullable();
            $table->unsignedTinyInteger('jumlah_siswa')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix').'sekolah');
    }
};
