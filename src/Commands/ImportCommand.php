<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;
use Kanekescom\Simgtk\Imports;
use Kanekescom\Simgtk\Models\JenjangSekolah;
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

    protected $importOptions = [
        'pegawai-dapodik' => Imports\PegawaiDapodikImport::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = now();
        $importOptions = $this->importOptions;

        $choiced = $this->choice(
            'What do you want to import?',
            collect($importOptions)->keys()->toArray(),
            null,
            null,
            true,
        );

        if (filled($choiced)) {
            $this->importJenjangSekolahIfNotExist();
        }

        foreach ($choiced as $choice) {
            $path_file = $this->ask('Path to XLSX file');

            if ($this->confirm('Do you wish to import data?', true)) {
                (new $this->importOptions[$choice])->withOutput($this->output)->import($path_file);
            }
        }

        $this->newLine();
        $this->comment("Processed in {$start->shortAbsoluteDiffForHumans(now(), 1)}");

        return self::SUCCESS;
    }

    public function importJenjangSekolahIfNotExist()
    {
        collect(config('simgtk.jenjang_sekolah'))
            ->each(function ($value, $key) {
                return JenjangSekolah::updateOrCreate(['kode' => $key], ['nama' => $value]);
            });
    }
}
