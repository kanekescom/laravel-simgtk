<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
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
            ['nama' => 'Guru Kelas SD/MI/SLB'],
            ['nama' => 'Pendidikan Agama Islam'],
            ['nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan'],
            ['nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
            ['nama' => 'Ilmu Pengetahuan Alam (IPA)'],
            ['nama' => 'Muatan Lokal Bahasa Daerah'],
            ['nama' => 'Pendidikan Agama Islam dan Budi Pekerti'],
            ['nama' => 'Matematika (Umum)'],
            ['nama' => 'Bahasa Inggris'],
            ['nama' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['nama' => 'Seni dan Budaya'],
            ['nama' => 'Bahasa Indonesia'],
            ['nama' => 'Prakarya'],
        ]);
    }
}
