<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Factories\BidangStudiSertifikasiFactory;

class BidangStudiSertifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BidangStudiSertifikasiFactory::new()
            ->count(5)
            ->create();
    }
}
