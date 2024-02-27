<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BidangStudiSertifikasi>
 */
class BidangStudiSertifikasiFactory extends Factory
{
    protected $model = BidangStudiSertifikasi::class;

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
