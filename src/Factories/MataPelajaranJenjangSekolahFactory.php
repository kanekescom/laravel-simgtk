<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\MataPelajaranJenjangSekolah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MataPelajaranJenjangSekolah>
 */
class MataPelajaranJenjangSekolahFactory extends Factory
{
    protected $model = MataPelajaranJenjangSekolah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenjang_sekolah_id' => JenjangSekolah::inRandomOrder()->first()->id ?? JenjangSekolahFactory::new()->create(),
            'mata_pelajaran_id' => MataPelajaran::inRandomOrder()->first()->id ?? MataPelajaranFactory::new()->create(),
        ];
    }
}
