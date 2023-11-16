<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kanekescom\Simgtk\Models\Sekolah>
 */
class SekolahFactory extends Factory
{
    protected $model = Sekolah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenjang_sekolah = JenjangSekolah::inRandomOrder()->first() ?? JenjangSekolahFactory::new()->create();

        return [
            'nama' => $jenjang_sekolah->nama.' '.fake()->unique()->company(),
            'npsn' => fake()->unique()->numerify('########'),
            'jenjang_sekolah_id' => $jenjang_sekolah->id,
            'tanggal_aktif' => fake()->boolean(10) ? null : now()->subYears(2)->startOfYear(),
            'tanggal_nonaktif' => fake()->boolean(90) ? null : now()->addYears(2)->endOfYear(),
        ];
    }
}
