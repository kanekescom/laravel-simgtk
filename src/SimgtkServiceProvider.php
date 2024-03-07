<?php

namespace Kanekescom\Simgtk;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\Permission\Models\Role;

class SimgtkServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-simgtk')
            ->hasConfigFile()
            ->hasMigrations([
                '2023_11_01_000001_create_simgtk_bidang_studi_pendidikan_table',
                '2023_11_01_000002_create_simgtk_bidang_studi_sertifikasi_table',
                '2023_11_01_000003_create_simgtk_jenis_ptk_table',
                '2023_11_01_000004_create_simgtk_jenjang_sekolah_table',
                '2023_11_01_000006_create_simgtk_mata_pelajaran_table',
                '2023_11_01_000007_create_simgtk_pegawai_table',
                '2023_11_01_000008_create_simgtk_wilayah_table',
                '2023_11_01_000009_create_simgtk_sekolah_table',
                '2023_11_01_000011_create_simgtk_bezetting_table',
                '2023_11_01_000010_create_simgtk_rencana_mutasi_table',
                '2023_11_01_000011_create_simgtk_usul_mutasi_table',
                '2023_11_01_000012_create_simgtk_rancangan_mutasi_table',
                '2023_11_01_000013_create_simgtk_rencana_bezetting_table',
                '2023_11_01_000014_create_simgtk_rancangan_bezetting_table',
                '2023_11_01_000015_create_simgtk_rancangan_bezetting_pegawai_table',
            ])
            ->runsMigrations()
            ->hasCommands([
                Commands\DemoSeedCommand::class,
                Commands\UserDemoSeedCommand::class,
                Commands\ImportCommand::class,
                Commands\TruncateCommand::class,
                Commands\FixSekolahAbkCommand::class,
                Commands\FillDefaultSekolahAbkCommand::class,
            ]);

        Gate::policy(Role::class, Policies\RolePolicy::class);

        Gate::policy(Models\AbkSekolah::class, Policies\AbkSekolahPolicy::class);
        Gate::policy(Models\AbkSekolahSd::class, Policies\AbkSekolahSdPolicy::class);
        Gate::policy(Models\AbkSekolahSmp::class, Policies\AbkSekolahSmpPolicy::class);
        Gate::policy(Models\BidangStudiPendidikan::class, Policies\BidangStudiPendidikanPolicy::class);
        Gate::policy(Models\BidangStudiSertifikasi::class, Policies\BidangStudiSertifikasiPolicy::class);
        Gate::policy(Models\RancanganBezettingSd::class, Policies\RancanganBezettingSdPolicy::class);
        Gate::policy(Models\RancanganBezettingSmp::class, Policies\RancanganBezettingSmpPolicy::class);
        Gate::policy(Models\JenisPtk::class, Policies\JenisPtkPolicy::class);
        Gate::policy(Models\JenjangSekolah::class, Policies\JenjangSekolahPolicy::class);
        Gate::policy(Models\LiveBezetting::class, Policies\LiveBezettingPolicy::class);
        Gate::policy(Models\LiveBezettingSd::class, Policies\LiveBezettingSdPolicy::class);
        Gate::policy(Models\LiveBezettingSmp::class, Policies\LiveBezettingSmpPolicy::class);
        Gate::policy(Models\MataPelajaran::class, Policies\MataPelajaranPolicy::class);
        Gate::policy(Models\PegawaiNonAsn::class, Policies\PegawaiNonAsnPolicy::class);
        Gate::policy(Models\PegawaiPns::class, Policies\PegawaiPnsPolicy::class);
        Gate::policy(Models\PegawaiPppk::class, Policies\PegawaiPppkPolicy::class);
        Gate::policy(Models\Pegawai::class, Policies\PegawaiPolicy::class);
        Gate::policy(Models\PensiunNonAsn::class, Policies\PensiunNonAsnPolicy::class);
        Gate::policy(Models\PensiunPns::class, Policies\PensiunPnsPolicy::class);
        Gate::policy(Models\PensiunPppk::class, Policies\PensiunPppkPolicy::class);
        Gate::policy(Models\Pensiun::class, Policies\PensiunPolicy::class);
        Gate::policy(Models\RancanganBezetting::class, Policies\RancanganBezettingPolicy::class);
        Gate::policy(Models\RencanaBezetting::class, Policies\RencanaBezettingPolicy::class);
        Gate::policy(Models\RencanaMutasi::class, Policies\RencanaMutasiPolicy::class);
        Gate::policy(Models\Sekolah::class, Policies\SekolahPolicy::class);
        Gate::policy(Models\SekolahSd::class, Policies\SekolahSdPolicy::class);
        Gate::policy(Models\SekolahSmp::class, Policies\SekolahSmpPolicy::class);
        Gate::policy(Models\UsulMutasi::class, Policies\UsulMutasiPolicy::class);
        Gate::policy(Models\Wilayah::class, Policies\WilayahPolicy::class);

        FilamentShield::configurePermissionIdentifierUsing(
            fn ($resource) => str($resource)
                ->toString()
        );
    }
}
