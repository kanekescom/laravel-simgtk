<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\MataPelajaranJenjangSekolah;

class MataPelajaranJenjangSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataPelajaranJenjangSekolah::factory()
            ->count(5)
            ->create();
    }
}
