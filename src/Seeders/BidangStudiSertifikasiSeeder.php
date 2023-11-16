<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;

class BidangStudiSertifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BidangStudiSertifikasi::factory()
            ->count(5)
            ->create();
    }
}
