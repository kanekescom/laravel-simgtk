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
            // ['kode' => 'paud', 'nama' => 'PAUD'],
            // ['kode' => 'tk', 'nama' => 'TK'],
            ['kode' => 'sd', 'nama' => 'SD'],
            ['kode' => 'smp', 'nama' => 'SMP'],
            // ['kode' => 'sma', 'nama' => 'SMA'],
            // ['kode' => 'smk', 'nama' => 'SMK'],
        ]);
    }
}
