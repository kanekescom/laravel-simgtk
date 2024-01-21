<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\MataPelajaran;

class MataPelajaranInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($kecamatan) {
            MataPelajaran::create($kecamatan);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'sd')->first()->id, 'kode' => 'sd_kelas', 'nama' => 'Kelas SD'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'sd')->first()->id, 'kode' => 'sd_penjaskes', 'nama' => 'Penjaskes SD'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'sd')->first()->id, 'kode' => 'sd_agama', 'nama' => 'Agama SD'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'sd')->first()->id, 'kode' => 'sd_agama_noni', 'nama' => 'Agama Non Islam SD'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_pai', 'nama' => 'PAI SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_pjok', 'nama' => 'PJOK SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_b_indonesia', 'nama' => 'B. Indonesia SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_b_inggris', 'nama' => 'B. Inggris SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_bk', 'nama' => 'BK SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_ipa', 'nama' => 'IPA SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_ips', 'nama' => 'IPS SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_matematika', 'nama' => 'Matematika SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_ppkn', 'nama' => 'PPPKN SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_prakarya', 'nama' => 'Prakarya SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_seni_budaya', 'nama' => 'Seni Budaya SMP'],
            ['jenjang_sekolah_id'=>JenjangSekolah::where('kode', 'smp')->first()->id, 'kode' => 'smp_b_sunda', 'nama' => 'B. Sunda SMP'],
        ]);
    }
}
