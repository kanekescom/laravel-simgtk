<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\RancanganMutasi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kanekescom\Simgtk\Models\RancanganMutasi>
 */
class RancanganMutasiFactory extends Factory
{
    protected $model = RancanganMutasi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pegawai_id' => ($pegawai = Pegawai::inRandomOrder()->first()) ?? PegawaiFactory::new()->create(),
            'sekolah_id' => ($sekolah = Sekolah::inRandomOrder()->first()) ?? ($sekolah = SekolahFactory::new())->create(),
            'mata_pelajaran_id' => MataPelajaran::where('jenjang_sekolah_id', $sekolah->jenjang_sekolah_id)->inRandomOrder()->first() ?? MataPelajaranFactory::new()->create(['jenjang_sekolah_id' => $sekolah->jenjang_sekolah_id]),
        ];
    }
}
