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
            // Wilayah::class,
            WilayahInRealSeeder::class,
            SekolahSeeder::class,
            // MataPelajaranJenjangSekolahSeeder::class,
            MataPelajaranJenjangSekolahInRealSeeder::class,
            PegawaiSeeder::class,
            MutasiSeeder::class,
            PensiunSeeder::class,
            BezzetingSeeder::class,
            ImporSeeder::class,
        ]);
    }
}
