<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenjangPendidikan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenjangPendidikan>
 */
class JenjangPendidikanFactory extends Factory
{
    protected $model = JenjangPendidikan::class;

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
