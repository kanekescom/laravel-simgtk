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
            $table->string('nik')->index('7_nik');
            $table->string('nuptk')->nullable()->index('7_nuptk');
            $table->string('nip')->nullable()->index('7_nip');
            $table->string('gender_kode')->index('7_gender_kode');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('jenjang_pendidikan_kode')->nullable()->index('7_jenjang_pendidikan_kode');

            $table->string('status_kepegawaian_kode');
            $table->unsignedTinyInteger('masa_kerja_tahun')->nullable();
            $table->unsignedTinyInteger('masa_kerja_bulan')->nullable();

            $table->date('tmt_cpns')->nullable();
            $table->date('tanggal_sk_cpns')->nullable();
            $table->string('nomor_sk_cpns')->nullable();

            $table->date('tmt_pns')->nullable();
            $table->date('tanggal_sk_pns')->nullable();
            $table->string('nomor_sk_pns')->nullable();

            $table->string('golongan_kode')->nullable()->index('7_golongan_kode');
            $table->date('tmt_pangkat')->nullable();
            $table->date('tanggal_sk_pangkat')->nullable();
            $table->string('nomor_sk_pangkat')->nullable();

            $table->date('tmt_pensiun')->nullable();
            $table->date('tanggal_sk_pensiun')->nullable();
            $table->string('nomor_sk_pensiun')->nullable();

            $table->foreignUlid('sekolah_id')->index('7_sekolah_id');
            $table->string('status_tugas_kode')->index('7_status_tugas_kode');
            $table->foreignUlid('jenis_ptk_id')->index('7_jenis_ptk_id');
            $table->foreignUlid('bidang_studi_pendidikan_id')->nullable()->index('7_bidang_studi_pendidikan_id');
            $table->foreignUlid('bidang_studi_sertifikasi_id')->nullable()->index('7_bidang_studi_sertifikasi_id');
            $table->foreignUlid('mata_pelajaran_id')->nullable()->index('7_mata_pelajaran_id');
            $table->unsignedTinyInteger('jam_mengajar_perminggu')->nullable();
            $table->boolean('is_kepsek')->default(false)->index('7_is_kepsek');
            $table->boolean('is_plt_kepsek')->default(false)->index('7_is_plt_kepsek');

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
