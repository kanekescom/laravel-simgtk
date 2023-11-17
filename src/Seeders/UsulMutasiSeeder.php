<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\UsulMutasiFactory;

class UsulMutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsulMutasiFactory::new()
            ->count(5)
            ->create();
    }
}
