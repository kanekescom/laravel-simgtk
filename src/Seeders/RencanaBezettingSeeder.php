<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\RencanaBezettingFactory;

class RencanaBezettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RencanaBezettingFactory::new()
            ->count(5)
            ->create();
    }
}
