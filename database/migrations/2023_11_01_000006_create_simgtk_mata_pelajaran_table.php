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
        Schema::create(config('simgtk.table_prefix').'mata_pelajaran', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenjang_sekolah_id')->nullable()->index('6_jenjang_sekolah_id');
            $table->string('kode')->nullable()->index('6_kode');
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix').'mata_pelajaran');
    }
};
