<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;

class BidangStudiPendidikanInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($kecamatan) {
            BidangStudiPendidikan::create($kecamatan);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            ['nama' => 'Biologi'],
            ['nama' => 'Ekonomi'],
            ['nama' => 'Fisika'],
            ['nama' => 'Lainnya'],
            ['nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
            ['nama' => 'Pendidikan Agama Islam'],
            ['nama' => 'Matematika'],
            ['nama' => 'Bahasa Inggris'],
            ['nama' => 'Pendidikan Kewarganegaraan (PKn)'],
            ['nama' => 'Bahasa Indonesia'],
            ['nama' => 'Pendidikan Ilmu Pengetahuan Sosial (IPS)'],
            ['nama' => 'Umum'],
            ['nama' => 'Ilmu Pengetahuan Alam (IPA)'],
            ['nama' => 'Pendidikan Jasmani dan Kesehatan'],
            ['nama' => 'lainnya'],
            ['nama' => 'Pendidikan Biologi'],
            ['nama' => 'Teknik Informatika'],
            ['nama' => 'Pendidikan Matematika'],
            ['nama' => 'Pendidikan Bahasa Inggris'],
            ['nama' => 'Bahasa Arab'],
            ['nama' => 'Teknik Manajemen Industri'],
            ['nama' => 'Pendidikan Kewarganegaraan (PKn)'],
            ['nama' => 'Geografi'],
            ['nama' => 'Pendidikan Bahasa Indonesia'],
            ['nama' => 'Bahasa dan Sastra Inggris'],
            ['nama' => 'Administrasi Perkantoran'],
            ['nama' => 'Pendidikan Luar Sekolah'],
            ['nama' => 'Pendidikan Umum'],
            ['nama' => 'Pendidikan Bahasa dan Sastra Indonesia'],
            ['nama' => 'Adat Istiadat'],
            ['nama' => 'Guru Kelas SD/MI'],
            ['nama' => 'Sistem Informasi'],
            ['nama' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['nama' => 'Kependidikan'],
            ['nama' => 'Bimbingan dan Konseling'],
            ['nama' => 'Ilmu Pendidikan'],
            ['nama' => 'Kependidikan Dasar'],
            ['nama' => 'Bahasa dan Sastra Indonesia'],
            ['nama' => 'Guru Kelas PAUD'],
        ]);
    }
}
