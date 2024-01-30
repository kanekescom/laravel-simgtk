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
            $table->string('nama');
            $table->string('npsn')->nullable()->index();
            $table->foreignUlid('jenjang_sekolah_id')->nullable()->index();
            $table->foreignUlid('wilayah_id')->nullable()->index();

            $table->unsignedTinyInteger('jumlah_kelas')->nullable();
            $table->unsignedTinyInteger('jumlah_rombel')->nullable();
            $table->unsignedSmallInteger('jumlah_siswa')->nullable();

            $jenjang_mapels = [
                'sd' => [
                    'kelas',
                    'penjaskes',
                    'agama',
                    'agama_noni',
                ],
                'smp' => [
                    'pai',
                    'pjok',
                    'b_indonesia',
                    'b_inggris',
                    'bk',
                    'ipa',
                    'ips',
                    'matematika',
                    'ppkn',
                    'prakarya',
                    'seni_budaya',
                    'b_sunda',
                    'tik',
                ],
            ];

            foreach ($jenjang_mapels as $jenjang_sekolah => $mapels) {
                foreach ($mapels as $mapel) {
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_abk")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_pns")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_pppk")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_gtt")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_total")->nullable();
                    $table->smallInteger("{$jenjang_sekolah}_{$mapel}_selisih")->nullable();

                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_pns")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_pppk")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_gtt")->nullable();
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_total")->nullable();
                    $table->smallInteger("{$jenjang_sekolah}_{$mapel}_existing_selisih")->nullable();
                }

                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_abk")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_pns")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_pppk")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_gtt")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_total")->nullable();
                $table->smallInteger("{$jenjang_sekolah}_formasi_selisih")->nullable();

                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_pns")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_pppk")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_gtt")->nullable();
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_total")->nullable();
                $table->smallInteger("{$jenjang_sekolah}_formasi_existing_selisih")->nullable();
            }

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
