<?php

namespace Kanekescom\Simgtk;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SimgtkServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-simgtk')
            ->hasMigrations([
                '2023_11_01_000001_create_simgtk_bidang_studi_pendidikan_table',
                '2023_11_01_000002_create_simgtk_bidang_studi_sertifikasi_table',
                '2023_11_01_000003_create_simgtk_jenis_ptk_table',
                '2023_11_01_000004_create_simgtk_jenjang_sekolah_table',
                '2023_11_01_000005_create_simgtk_mata_pelajaran_jenjang_sekolah_table',
                '2023_11_01_000006_create_simgtk_mata_pelajaran_table',
                '2023_11_01_000007_create_simgtk_pegawai_table',
                '2023_11_01_000008_create_simgtk_wilayah_table',
                '2023_11_01_000009_create_simgtk_sekolah_table',
                '2023_11_01_000010_create_simgtk_mutasi_table',
                '2023_11_01_000011_create_simgtk_pensiun_table',
                '2023_11_01_000012_create_simgtk_bezzeting_table',
                '2023_11_01_000013_create_simgtk_impor_table',
                '2023_11_01_000014_create_simgtk_rancangan_mutasi_table',
            ])
            ->runsMigrations()
            ->hasCommand(Commands\SeedCommand::class);
    }
}
