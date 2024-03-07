<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\JenjangPendidikanFactory;

class JenjangPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenjangPendidikanFactory::new()
            ->count(5)
            ->create();
    }
}
