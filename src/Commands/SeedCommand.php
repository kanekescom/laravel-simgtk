<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed data to database from faker';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => 'Kanekescom\Simgtk\Seeders\DatabaseSeeder',
        ]);

        return self::SUCCESS;
    }
}
