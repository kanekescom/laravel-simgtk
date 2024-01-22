<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Mutasi;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\RancanganMutasi;
use Kanekescom\Simgtk\Models\Sekolah;

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
            'rancangan_mutasi_id' => RancanganMutasi::inRandomOrder()->first()->id ?? RancanganMutasiFactory::new()->create(),
            'pegawai_id' => ($pegawai = Pegawai::inRandomOrder()->first())->id ?? PegawaiFactory::new()->create(),
            'asal_sekolah_id' => $pegawai->sekolah_id,
            'tujuan_sekolah_id' => Sekolah::where('jenjang_sekolah_id', $pegawai->sekolah->jenjang_sekolah_id)->inRandomOrder()->first()->id ?? SekolahFactory::new()->create(),
            'tujuan_mata_pelajaran_id' => MataPelajaran::where('jenjang_sekolah_id', $pegawai->sekolah->jenjang_sekolah_id)->inRandomOrder()->first()->id ?? MataPelajaranFactory::new()->create(),
        ];
    }
}
