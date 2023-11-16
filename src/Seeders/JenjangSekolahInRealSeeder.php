<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class JenjangSekolahInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($kecamatan) {
            JenjangSekolah::create($kecamatan);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            ['nama' => 'PAUD'],
            ['nama' => 'TK'],
            ['nama' => 'SD'],
            ['nama' => 'SMP'],
            ['nama' => 'SMA'],
            ['nama' => 'SMK'],
        ]);
    }
}
