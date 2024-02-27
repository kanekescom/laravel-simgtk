<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;
use Kanekescom\Simgtk\Models;

class TruncateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate data from database';

    protected $modelOptions = [
        'bidang-studi-pendidikan' => Models\BidangStudiPendidikan::class,
        'bidang-studi-sertifikasi' => Models\BidangStudiSertifikasi::class,
        'jenis-ptk' => Models\JenisPtk::class,
        'jenjang-sekolah' => Models\JenjangSekolah::class,
        'mata-pelajaran' => Models\MataPelajaran::class,
        'pegawai' => Models\Pegawai::class,
        'sekolah' => Models\Sekolah::class,
        'wilayah' => Models\Wilayah::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = now();
        $modelOptions = $this->modelOptions;

        $choiced = $this->choice(
            'What do you want to model?',
            collect($modelOptions)->keys()->toArray(),
            null,
            null,
            true,
        );

        if ($this->confirm('Do you wish to truncate data?', true)) {
            foreach ($choiced as $choice) {
                $this->modelOptions[$choice]::truncate();
            }
        }

        $this->newLine();
        $this->comment("Processed in {$start->shortAbsoluteDiffForHumans(now(), 1)}");

        return self::SUCCESS;
    }
}
