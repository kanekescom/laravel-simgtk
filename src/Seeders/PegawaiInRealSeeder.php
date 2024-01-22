<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\JenjangPegawai;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Wilayah;

class PegawaiInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PegawaiFactory::new()
            ->count(50)
            ->create();

        // $this->data()->each(function ($data) {
        //     Pegawai::create($data);
        // });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([

        ]);
    }
}
