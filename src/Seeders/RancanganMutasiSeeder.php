<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\RancanganMutasiFactory;

class RancanganMutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RancanganMutasiFactory::new()
            ->count(5)
            ->create();
    }
}
