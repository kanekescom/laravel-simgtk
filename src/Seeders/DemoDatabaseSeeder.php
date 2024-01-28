<?php

namespace Kanekescom\Simgtk\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DemoDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BidangStudiPendidikanSeeder::class,
            BidangStudiSertifikasiSeeder::class,
            JenisPtkSeeder::class,
            JenjangSekolahSeeder::class,
            MataPelajaranSeeder::class,
            WilayahSeeder::class,
            SekolahSeeder::class,
            PegawaiSeeder::class,
            RencanaMutasiSeeder::class,
            UsulMutasiSeeder::class,
            RencanaBezzetingSeeder::class,
        ]);
    }
}
