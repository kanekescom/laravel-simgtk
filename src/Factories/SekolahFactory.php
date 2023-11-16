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
        $jumlah_ruang_kelas = fake()->numberBetween(6, 20);
        $jumlah_ruang_rombel = $jumlah_ruang_kelas - fake()->numberBetween(0, 3);
        $jumlah_siswa = $jumlah_ruang_kelas * fake()->numberBetween(35, 45);

        return [
            'nama' => $jenjang_sekolah->nama.' '.fake()->unique()->company(),
            'npsn' => fake()->unique()->numerify('########'),
            'jenjang_sekolah_id' => $jenjang_sekolah->id,
            'jumlah_ruang_kelas' => $jumlah_ruang_kelas,
            'jumlah_ruang_rombel' => $jumlah_ruang_rombel,
            'jumlah_siswa' => $jumlah_siswa,
            'tanggal_aktif' => fake()->boolean(10) ? null : now()->subYears(2)->startOfYear(),
            'tanggal_nonaktif' => fake()->boolean(90) ? null : now()->addYears(2)->endOfYear(),
        ];
    }
}
