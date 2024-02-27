<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BidangStudiPendidikan>
 */
class BidangStudiPendidikanFactory extends Factory
{
    protected $model = BidangStudiPendidikan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->sentence(3),
        ];
    }
}
