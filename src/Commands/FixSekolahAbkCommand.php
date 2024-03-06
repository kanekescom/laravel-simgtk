<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;
use Kanekescom\Simgtk\Models\Sekolah;

class FixSekolahAbkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:fix-sekolah-abk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixing sekolah ABK data from database';

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
            $sekolah->touch();

            $bar->advance();
        });

        $this->newLine();
        $this->comment("Processed in {$start->shortAbsoluteDiffForHumans(now(), 1)}");

        return self::SUCCESS;
    }
}
