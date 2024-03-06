<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;
use Kanekescom\Simgtk\Models\Sekolah;

class FillDefaultSekolahAbkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:fill-default-sekolah-abk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill ABK sekolah data with default from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = now();
        $sekolahs = Sekolah::all();

        $bar = $this->output->createProgressBar($sekolahs->count());
        $bar->start();

        $sekolahs->each(function ($sekolah) use ($bar) {
            $jenjang_mapels = [
                'sd' => [
                    'kelas',
                    'penjaskes',
                    'agama',
                    'agama_noni',
                ],
                'smp' => [
                    'pai',
                    'pjok',
                    'b_indonesia',
                    'b_inggris',
                    'bk',
                    'ipa',
                    'ips',
                    'matematika',
                    'ppkn',
                    'prakarya',
                    'seni_budaya',
                    'b_sunda',
                    'tik',
                ],
            ];

            if ($sekolah->jenjangSekolah?->kode == 'sd') {
                $sekolah->sd_kelas_abk = $sekolah->sd_kelas_abk != 0 ? $sekolah->sd_kelas_abk : 6;
                $sekolah->sd_penjaskes_abk = $sekolah->sd_penjaskes_abk != 0 ? $sekolah->sd_penjaskes_abk : 1;
                $sekolah->sd_agama_abk = $sekolah->sd_agama_abk != 0 ? $sekolah->sd_agama_abk : 1;
                $sekolah->sd_agama_noni_abk = $sekolah->sd_agama_noni_abk != 0 ? $sekolah->sd_agama_noni_abk : 0;
            }

            if ($sekolah->jenjangSekolah?->kode == 'smp') {
                $jenjang_sekolah = 'smp';
                $mapels = $jenjang_mapels['smp'];

                foreach ($mapels as $mapel) {
                    $sekolah->{"{$jenjang_sekolah}_{$mapel}_abk"} = $sekolah->{"{$jenjang_sekolah}_{$mapel}_abk"} != 0 ? $sekolah->{"{$jenjang_sekolah}_{$mapel}_abk"} : 1;
                }
            }

            $sekolah->update();

            $bar->advance();
        });

        $this->newLine();
        $this->comment("Processed in {$start->shortAbsoluteDiffForHumans(now(), 1)}");

        return self::SUCCESS;
    }
}
