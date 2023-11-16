<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;

class BidangStudiSertifikasiInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($kecamatan) {
            BidangStudiSertifikasi::create($kecamatan);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            ['nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
            ['nama' => 'Ilmu Pengetahuan Alam (IPA)'],
            ['nama' => 'Pendidikan Agama Islam'],
            ['nama' => 'Seni Budaya'],
            ['nama' => 'Bahasa Indonesia'],
            ['nama' => 'Bahasa Inggris'],
            ['nama' => 'Pendidikan Kewarganegaraan (Pkn)'],
            ['nama' => 'Pendidikan Jasmani dan Kesehatan'],
            ['nama' => 'Matematika'],
            ['nama' => 'Pendidikan Jasmani (OR dan kesehatan)'],
            ['nama' => 'Biologi'],
            ['nama' => 'Guru Kelas SD/MI'],
            ['nama' => 'Guru Kelas SDLB'],
        ]);
    }
}
