<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\RencanaMutasiFactory;

class RencanaMutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RencanaMutasiFactory::new()
            ->count(5)
            ->create();
    }
}
