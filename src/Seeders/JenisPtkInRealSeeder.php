<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\JenisPtk;

class JenisPtkInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($kecamatan) {
            JenisPtk::create($kecamatan);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            ['nama' => 'Tenaga Administrasi Sekolah'],
            ['nama' => 'Guru Mapel'],
            ['nama' => 'Kepala Sekolah'],
            ['nama' => 'Penjaga Sekolah'],
            ['nama' => 'Guru Kelas'],
        ]);
    }
}
