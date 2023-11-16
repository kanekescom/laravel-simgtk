<?php

it('can run simgtk:seed', function () {
    $this->artisan('migrate:refresh')
        ->assertSuccessful();

    $this->artisan('simgtk:seed')
        ->assertSuccessful();
});
