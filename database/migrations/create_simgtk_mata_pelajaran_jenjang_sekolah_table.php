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
        Schema::create(config('simgtk.table_prefix') . 'mata_pelajaran_jenjang_sekolah', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenjang_sekolah_id')->index();
            $table->foreignUlid('mata_pelajaran_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix') . 'mata_pelajaran_jenjang_sekolah');
    }
};
