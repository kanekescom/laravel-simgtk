<?php

namespace Kanekescom\Simgtk\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // BidangStudiPendidikanSeeder::class,
            BidangStudiPendidikanInRealSeeder::class,
            // BidangStudiSertifikasiSeeder::class,
            BidangStudiSertifikasiInRealSeeder::class,
            // JenisPtkSeeder::class,
            JenisPtkInRealSeeder::class,
            // JenjangSekolahSeeder::class,
            JenjangSekolahInRealSeeder::class,
            // MataPelajaranSeeder::class,
            MataPelajaranInRealSeeder::class,
            SekolahSeeder::class,
            PegawaiSeeder::class,
        ]);
    }
}
