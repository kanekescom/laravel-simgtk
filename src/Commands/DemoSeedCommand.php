<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;

class DemoSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:seed-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the demo data into the database from faker';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => 'Kanekescom\Simgtk\Seeders\DemoDatabaseSeeder',
        ]);

        return self::SUCCESS;
    }
}
