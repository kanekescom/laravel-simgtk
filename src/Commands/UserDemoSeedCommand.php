<?php

namespace Kanekescom\Simgtk\Commands;

use Illuminate\Console\Command;

class UserDemoSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simgtk:seed-user-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed User demo data into database from faker';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => 'Kanekescom\Simgtk\Seeders\UserSeeder',
        ]);

        return self::SUCCESS;
    }
}
