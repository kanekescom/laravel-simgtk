<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\RencanaBezzetingFactory;

class RencanaBezzetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RencanaBezzetingFactory::new()
            ->count(5)
            ->create();
    }
}
