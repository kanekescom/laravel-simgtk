<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenisPtk;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisPtk>
 */
class JenisPtkFactory extends Factory
{
    protected $model = JenisPtk::class;

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
