<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;
use Kanekescom\Simgtk\Models;
use Kanekescom\Simgtk\Imports;
use Maatwebsite\Excel\Facades\Excel;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data into database from php file';

    protected $modelOptions = [
        'bidang-studi-pendidikan' => Models\BidangStudiPendidikan::class,
        'bidang-studi-sertifkasi' => Models\BidangStudiSertifikasi::class,
        'jenis-ptk' => Models\JenisPtk::class,
        'jenjang-sekolah' => Models\JenjangSekolah::class,
        'mata-pelajaran' => Models\MataPelajaran::class,
        'wilayah' => Models\Wilayah::class,
        'sekolah' => Models\Sekolah::class,
        'pegawai' => Models\Pegawai::class,
        'rencana-bezzeting' => Models\RencanaBezzeting::class,
        'rencana-mutasi' => Models\RencanaMutasi::class,
        'usul-mutasi' => Models\UsulMutasi::class,
        'rancangan-mutasi' => Models\RancanganMutasi::class,
    ];

    protected $importOptions = [
        'bidang-studi-pendidikan' => Imports\BidangStudiPendidikanImport::class,
        'bidang-studi-sertifkasi' => Imports\BidangStudiSertifikasiImport::class,
        'jenis-ptk' => Imports\JenisPtkImport::class,
        'jenjang-sekolah' => Imports\JenjangSekolahImport::class,
        'mata-pelajaran' => Imports\MataPelajaranImport::class,
        'wilayah' => Imports\WilayahImport::class,
        'sekolah' => Imports\SekolahImport::class,
        // 'pegawai' => Imports\Pegawai::class,
        'rencana-bezzeting' => Imports\RencanaBezzetingImport::class,
        'rencana-mutasi' => Imports\RencanaMutasiImport::class,
        'usul-mutasi' => Imports\UsulMutasiImport::class,
        // 'rancangan-mutasi' => Imports\RancanganMutasiImport::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelOptions = $this->modelOptions;

        $choiced = $this->choice(
            'What do you want to import?',
            collect($modelOptions)->keys()->toArray(),
            0,
            null,
            true,
        );

        foreach ($choiced as $choice) {
            if ($this->confirm(isset($this->importOptions[$choice])
                ? "Do you wish to truncate {$choice} data?"
                : "{$choice} import class does not exist. Do you wish to only truncate data?")) {
                $this->modelOptions[$choice]::truncate();
            }

            if (isset($this->importOptions[$choice])) {
                $path_file = $this->ask('Path to XLSX file');

                if ($this->confirm('Do you wish to import data?')) {
                    Excel::import(new $this->importOptions[$choice], $path_file);
                }
            }
        }

        return self::SUCCESS;
    }
}
