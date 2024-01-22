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
            $table->foreignUlid('wilayah_id')->nullable()->index();
            $table->unsignedTinyInteger('jumlah_kelas')->nullable();
            $table->unsignedTinyInteger('jumlah_rombel')->nullable();
            $table->unsignedSmallInteger('jumlah_siswa')->nullable();

            $table->unsignedSmallInteger('kepala_sekolah')->nullable();

            $table->unsignedSmallInteger('sd_kelas_abk')->nullable();
            $table->unsignedSmallInteger('sd_kelas_pns')->nullable();
            $table->unsignedSmallInteger('sd_kelas_pppk')->nullable();
            $table->unsignedSmallInteger('sd_kelas_gtt')->nullable();

            $table->unsignedSmallInteger('sd_penjaskes_abk')->nullable();
            $table->unsignedSmallInteger('sd_penjaskes_pns')->nullable();
            $table->unsignedSmallInteger('sd_penjaskes_pppk')->nullable();
            $table->unsignedSmallInteger('sd_penjaskes_gtt')->nullable();

            $table->unsignedSmallInteger('sd_agama_abk')->nullable();
            $table->unsignedSmallInteger('sd_agama_pns')->nullable();
            $table->unsignedSmallInteger('sd_agama_pppk')->nullable();
            $table->unsignedSmallInteger('sd_agama_gtt')->nullable();

            $table->unsignedSmallInteger('sd_agama_noni_abk')->nullable();
            $table->unsignedSmallInteger('sd_agama_noni_pns')->nullable();
            $table->unsignedSmallInteger('sd_agama_noni_pppk')->nullable();
            $table->unsignedSmallInteger('sd_agama_noni_gtt')->nullable();

            $table->unsignedSmallInteger('smp_pai_abk')->nullable();
            $table->unsignedSmallInteger('smp_pai_pns')->nullable();
            $table->unsignedSmallInteger('smp_pai_pppk')->nullable();
            $table->unsignedSmallInteger('smp_pai_gtt')->nullable();

            $table->unsignedSmallInteger('smp_pjok_abk')->nullable();
            $table->unsignedSmallInteger('smp_pjok_pns')->nullable();
            $table->unsignedSmallInteger('smp_pjok_pppk')->nullable();
            $table->unsignedSmallInteger('smp_pjok_gtt')->nullable();

            $table->unsignedSmallInteger('smp_b_indonesia_abk')->nullable();
            $table->unsignedSmallInteger('smp_b_indonesia_pns')->nullable();
            $table->unsignedSmallInteger('smp_b_indonesia_pppk')->nullable();
            $table->unsignedSmallInteger('smp_b_indonesia_gtt')->nullable();

            $table->unsignedSmallInteger('smp_b_inggris_abk')->nullable();
            $table->unsignedSmallInteger('smp_b_inggris_pns')->nullable();
            $table->unsignedSmallInteger('smp_b_inggris_pppk')->nullable();
            $table->unsignedSmallInteger('smp_b_inggris_gtt')->nullable();

            $table->unsignedSmallInteger('smp_bk_abk')->nullable();
            $table->unsignedSmallInteger('smp_bk_pns')->nullable();
            $table->unsignedSmallInteger('smp_bk_pppk')->nullable();
            $table->unsignedSmallInteger('smp_bk_gtt')->nullable();

            $table->unsignedSmallInteger('smp_ipa_abk')->nullable();
            $table->unsignedSmallInteger('smp_ipa_pns')->nullable();
            $table->unsignedSmallInteger('smp_ipa_pppk')->nullable();
            $table->unsignedSmallInteger('smp_ipa_gtt')->nullable();

            $table->unsignedSmallInteger('smp_ips_abk')->nullable();
            $table->unsignedSmallInteger('smp_ips_pns')->nullable();
            $table->unsignedSmallInteger('smp_ips_pppk')->nullable();
            $table->unsignedSmallInteger('smp_ips_gtt')->nullable();

            $table->unsignedSmallInteger('smp_matematika_abk')->nullable();
            $table->unsignedSmallInteger('smp_matematika_pns')->nullable();
            $table->unsignedSmallInteger('smp_matematika_pppk')->nullable();
            $table->unsignedSmallInteger('smp_matematika_gtt')->nullable();

            $table->unsignedSmallInteger('smp_ppkn_abk')->nullable();
            $table->unsignedSmallInteger('smp_ppkn_pns')->nullable();
            $table->unsignedSmallInteger('smp_ppkn_pppk')->nullable();
            $table->unsignedSmallInteger('smp_ppkn_gtt')->nullable();

            $table->unsignedSmallInteger('smp_prakarya_abk')->nullable();
            $table->unsignedSmallInteger('smp_prakarya_pns')->nullable();
            $table->unsignedSmallInteger('smp_prakarya_pppk')->nullable();
            $table->unsignedSmallInteger('smp_prakarya_gtt')->nullable();

            $table->unsignedSmallInteger('smp_seni_budaya_abk')->nullable();
            $table->unsignedSmallInteger('smp_seni_budaya_pns')->nullable();
            $table->unsignedSmallInteger('smp_seni_budaya_pppk')->nullable();
            $table->unsignedSmallInteger('smp_seni_budaya_gtt')->nullable();

            $table->unsignedSmallInteger('smp_b_sunda_abk')->nullable();
            $table->unsignedSmallInteger('smp_b_sunda_pns')->nullable();
            $table->unsignedSmallInteger('smp_b_sunda_pppk')->nullable();
            $table->unsignedSmallInteger('smp_b_sunda_gtt')->nullable();

            $table->unsignedSmallInteger('smp_tik_abk')->nullable();
            $table->unsignedSmallInteger('smp_tik_pns')->nullable();
            $table->unsignedSmallInteger('smp_tik_pppk')->nullable();
            $table->unsignedSmallInteger('smp_tik_gtt')->nullable();

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
