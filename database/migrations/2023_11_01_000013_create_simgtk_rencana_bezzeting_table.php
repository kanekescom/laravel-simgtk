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
        Schema::create(config('simgtk.table_prefix') . 'rencana_bezzeting', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->boolean('is_aktif')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix') . 'rencana_bezzeting');
    }
};
