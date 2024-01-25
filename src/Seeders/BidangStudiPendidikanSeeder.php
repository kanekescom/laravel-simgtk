<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\BidangStudiPendidikanFactory;

class BidangStudiPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BidangStudiPendidikanFactory::new()
            ->count(5)
            ->create();
    }
}
