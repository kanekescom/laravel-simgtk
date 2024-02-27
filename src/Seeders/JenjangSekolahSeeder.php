<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\JenjangSekolahFactory;

class JenjangSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenjangSekolahFactory::new()
            ->count(5)
            ->create();
    }
}
