<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\Wilayah;

class SekolahInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($kecamatan) {
            Sekolah::create($kecamatan);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([

        ]);
    }
}
