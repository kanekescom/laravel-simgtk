<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\Mutasi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kanekescom\Simgtk\Models\Mutasi>
 */
class MutasiFactory extends Factory
{
    protected $model = Mutasi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pegawai_id' => Pegawai::inRandomOrder()->first()->id ?? PegawaiFactory::new()->create(),
            'asal_sekolah_id' => Sekolah::inRandomOrder()->first()->id ?? SekolahFactory::new()->create(),
            'tujuan_sekolah_id' => Sekolah::inRandomOrder()->first()->id ?? SekolahFactory::new()->create(),
        ];
    }
}
