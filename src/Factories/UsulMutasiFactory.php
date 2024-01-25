<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\UsulMutasi;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\RencanaMutasi;
use Kanekescom\Simgtk\Models\Sekolah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kanekescom\Simgtk\Models\UsulMutasi>
 */
class UsulMutasiFactory extends Factory
{
    protected $model = UsulMutasi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rencana_mutasi_id' => RencanaMutasi::inRandomOrder()->first() ?? RencanaMutasiFactory::new()->create(),
            'pegawai_id' => ($pegawai = Pegawai::inRandomOrder()->first()) ?? PegawaiFactory::new()->create(),
            'asal_sekolah_id' => $pegawai->sekolah_id,
            'tujuan_sekolah_id' => Sekolah::where('jenjang_sekolah_id', $pegawai->sekolah->jenjang_sekolah_id)->inRandomOrder()->first() ?? SekolahFactory::new()->create(),
            'tujuan_mata_pelajaran_id' => MataPelajaran::where('jenjang_sekolah_id', $pegawai->sekolah->jenjang_sekolah_id)->inRandomOrder()->first() ?? MataPelajaranFactory::new()->create(),
        ];
    }
}
