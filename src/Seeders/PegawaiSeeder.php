<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::factory()
            ->count(15)
            ->create();
    }
}
