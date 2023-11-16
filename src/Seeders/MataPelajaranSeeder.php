<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataPelajaran::factory()
            ->count(5)
            ->create();
    }
}
