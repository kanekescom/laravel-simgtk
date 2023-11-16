<?php

method_public(\Kanekescom\Simgtk\Referensi::class)
    ->reject(function ($method) {
        return strpos($method, '__') === 0;
    })
    ->each(function ($method) {
        $testName = \Illuminate\Support\Str::of($method)->headline()->lower();

        it("can {$testName}", function () use ($method) {
            $limit = 10;
            $offset = 0;
            $response = \Kanekescom\Simgtk\Facades\Referensi::$method([
                'limit' => $limit,
                'offset' => $offset,
            ]);

            expect($response->toArray())->toBeArray();
        });
    });
