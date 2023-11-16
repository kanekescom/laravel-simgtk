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
                'create_simgtk_bidang_studi_pendidikan_table',
                'create_simgtk_bidang_studi_sertifikasi_table',
                'create_simgtk_jenis_ptk_table',
                'create_simgtk_jenjang_sekolah_table',
                'create_simgtk_mata_pelajaran_table',
                'create_simgtk_pegawai_table',
                'create_simgtk_sekolah_table',
            ])
            ->runsMigrations()
            ->hasCommand(Commands\SeedCommand::class);
    }
}
