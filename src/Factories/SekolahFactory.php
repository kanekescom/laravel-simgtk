<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\Wilayah;

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
        return [
            'nama' => ($jenjang_sekolah = JenjangSekolah::inRandomOrder()->first() ?? JenjangSekolahFactory::new()->create())->nama.' '.fake()->unique()->company(),
            'npsn' => fake()->unique()->numerify('########'),
            'jenjang_sekolah_id' => $jenjang_sekolah->id,
            'wilayah_id' => Wilayah::inRandomOrder()->first() ?? WilayahFactory::new()->create(),
            'jumlah_kelas' => $jumlah_kelas = fake()->numberBetween(6, 20),
            'jumlah_rombel' => $jumlah_kelas - fake()->numberBetween(0, 3),
            'jumlah_siswa' => $jumlah_kelas * fake()->numberBetween(35, 45),
        ];
    }
}
