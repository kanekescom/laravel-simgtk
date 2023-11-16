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
        Schema::create(config('simgtk.table_prefix') . 'pegawai', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nik')->index('nik');
            $table->string('nuptk')->index('nuptk')->nullable();
            $table->string('nip')->index('nip')->nullable();
            $table->string('gender_kode')->index('gender_kode');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('jenjang_pendidikan_kode');

            $table->string('status_kepegawaian_kode');
            $table->unsignedTinyInteger('masa_kerja_tahun')->nullable();
            $table->unsignedTinyInteger('masa_kerja_bulan')->nullable();

            $table->string('tmt_cpns')->nullable();
            $table->string('tanggal_sk_cpns')->nullable();
            $table->string('nomor_sk_cpns')->nullable();

            $table->string('tmt_pns')->nullable();
            $table->string('tanggal_sk_pns')->nullable();
            $table->string('nomor_sk_pns')->nullable();

            $table->string('tmt_pensiun')->nullable();
            $table->string('tanggal_sk_pensiun')->nullable();
            $table->string('nomor_sk_pensiun')->nullable();

            $table->string('golongan_kode')->nullable();
            $table->string('tmt_pangkat')->nullable();
            $table->string('tanggal_sk_pangkat')->nullable();
            $table->string('nomor_sk_pangkat')->nullable();

            $table->string('sekolah_id');
            $table->string('status_tugas_kode');
            $table->string('jenis_ptk_id');
            $table->string('bidang_studi_pendidikan_id')->nullable();
            $table->string('bidang_studi_sertifikasi_id')->nullable();
            $table->string('mata_pelajaran_diajarkan_id')->nullable();
            $table->double('jam_mengajar_perminggu', 2, 2)->nullable();
            $table->boolean('is_kepsek');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('simgtk.table_prefix') . 'pegawai');
    }
};
