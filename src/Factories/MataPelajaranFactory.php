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
        $jenjang_sekolah = JenjangSekolah::inRandomOrder()->first() ?? JenjangSekolahFactory::new()->create();

        return [
            'jenjang_sekolah_id' => $jenjang_sekolah->id,
            'kode' => fake()->unique()->numerify('##.##.##'),
            'nama' => fake()->unique()->sentence(3),
        ];
    }
}
