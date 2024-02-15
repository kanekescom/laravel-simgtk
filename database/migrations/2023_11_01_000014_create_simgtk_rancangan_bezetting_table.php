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
        Schema::create(config('simgtk.table_prefix') . 'rancangan_bezetting', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('rencana_bezetting_id')->index();
            $table->foreignUlid('sekolah_id')->index();
            $table->string('nama');
            $table->string('npsn')->nullable()->index();
            $table->foreignUlid('jenjang_sekolah_id')->nullable()->index();
            $table->foreignUlid('wilayah_id')->nullable()->index();

            $table->unsignedTinyInteger('jumlah_kelas')->default(0);
            $table->unsignedTinyInteger('jumlah_rombel')->default(0);
            $table->unsignedSmallInteger('jumlah_siswa')->default(0);

            $table->unsignedSmallInteger('kepsek')->default(0);
            $table->unsignedSmallInteger('plt_kepsek')->default(0);
            $table->smallInteger('jabatan_kepsek')->default(0);

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
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_abk")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_pns")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_pppk")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_gtt")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_total")->default(0);
                    $table->smallInteger("{$jenjang_sekolah}_{$mapel}_selisih")->default(0);

                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_pns")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_pppk")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_gtt")->default(0);
                    $table->unsignedSmallInteger("{$jenjang_sekolah}_{$mapel}_existing_total")->default(0);
                    $table->smallInteger("{$jenjang_sekolah}_{$mapel}_existing_selisih")->default(0);
                }

                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_abk")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_pns")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_pppk")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_gtt")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_total")->default(0);
                $table->smallInteger("{$jenjang_sekolah}_formasi_selisih")->default(0);

                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_pns")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_pppk")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_gtt")->default(0);
                $table->unsignedSmallInteger("{$jenjang_sekolah}_formasi_existing_total")->default(0);
                $table->smallInteger("{$jenjang_sekolah}_formasi_existing_selisih")->default(0);
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
        Schema::dropIfExists(config('simgtk.table_prefix') . 'rancangan_bezetting');
    }
};
