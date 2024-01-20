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
        Schema::create(config('simgtk.table_prefix').'pegawai', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nik')->index();
            $table->string('nuptk')->index()->nullable();
            $table->string('nip')->index()->nullable();
            $table->string('gender_kode')->index();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('jenjang_pendidikan_kode')->index();

            $table->string('status_kepegawaian_kode');
            $table->unsignedTinyInteger('masa_kerja_tahun')->nullable();
            $table->unsignedTinyInteger('masa_kerja_bulan')->nullable();

            $table->date('tmt_cpns')->nullable();
            $table->date('tanggal_sk_cpns')->nullable();
            $table->string('nomor_sk_cpns')->nullable();

            $table->date('tmt_pns')->nullable();
            $table->date('tanggal_sk_pns')->nullable();
            $table->string('nomor_sk_pns')->nullable();

            $table->string('golongan_kode')->index()->nullable();
            $table->date('tmt_pangkat')->nullable();
            $table->date('tanggal_sk_pangkat')->nullable();
            $table->string('nomor_sk_pangkat')->nullable();

            $table->date('tmt_pensiun')->nullable();
            $table->date('tanggal_sk_pensiun')->nullable();
            $table->string('nomor_sk_pensiun')->nullable();

            $table->foreignUlid('sekolah_id')->index();
            $table->string('status_tugas_kode')->index();
            $table->foreignUlid('jenis_ptk_id')->index();
            $table->foreignUlid('bidang_studi_pendidikan_id')->index()->nullable();
            $table->foreignUlid('bidang_studi_sertifikasi_id')->index()->nullable();
            $table->foreignUlid('mata_pelajaran_id')->index()->nullable();
            $table->double('jam_mengajar_perminggu', 3, 1)->nullable();
            $table->boolean('is_kepsek')->index();
            $table->boolean('is_plt_kepsek')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix').'pegawai');
    }
};
