<?php

namespace Kanekescom\Simgtk\Tests;

use Kanekescom\Simgtk\ReferensiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ReferensiServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('siasn-api', require __DIR__ . '/../vendor/kanekescom/laravel-siasn-api/config/siasn-api.php');
        $app['config']->set('simgtk-api', require __DIR__ . '/../vendor/kanekescom/laravel-simgtk-api/config/simgtk-api.php');
    }
}
