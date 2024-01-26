<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\MataPelajaran;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MataPelajaran>
 */
class MataPelajaranFactory extends Factory
{
    protected $model = MataPelajaran::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenjang_sekolah_id' => JenjangSekolah::inRandomOrder()->first() ?? JenjangSekolahFactory::new()->create()->id,
            'kode' => fake()->unique()->numerify('##.##.##'),
            'nama' => fake()->unique()->sentence(3),
            'singkatan' => strtoupper(fake()->unique()->word()),
        ];
    }
}
