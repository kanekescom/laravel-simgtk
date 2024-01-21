<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenjangSekolah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenjangSekolah>
 */
class JenjangSekolahFactory extends Factory
{
    protected $model = JenjangSekolah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->numerify('##.##.##'),
            'nama' => strtoupper(fake()->unique()->word()),
        ];
    }
}
