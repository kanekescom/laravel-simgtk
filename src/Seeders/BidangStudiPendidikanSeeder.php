<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;

class BidangStudiPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BidangStudiPendidikan::factory()
            ->count(5)
            ->create();
    }
}
