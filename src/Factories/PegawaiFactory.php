<?php

namespace Kanekescom\Simgtk\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;
use Kanekescom\Simgtk\Models\JenisPtk;
use Kanekescom\Simgtk\Models\JenjangPendidikan;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kanekescom\Simgtk\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal_lahir = fake()->dateTimeBetween('-50 years', '-18 years');
        $status_kepegawaian_kode = fake()->randomElement(StatusKepegawaianEnum::class);

        $is_asn = in_array($status_kepegawaian_kode, [StatusKepegawaianEnum::PNS, StatusKepegawaianEnum::PPPK]);
        $is_pns = in_array($status_kepegawaian_kode, [StatusKepegawaianEnum::PNS]);
        $is_pensiun = $is_asn ? fake()->boolean(10) : false;

        $tanggal_cpns = now()->parse(fake()->dateTimeBetween('-10 years', '0 years'));
        $tanggal_pns = $is_pns
            ? ($tanggal_cpns->addYears(2)->isPast() ? $tanggal_cpns->addYears(2) : null)
            : now()->parse(fake()->dateTimeBetween('-2 years', '0 years'));
        $tanggal_pangkat = now()->parse(fake()->dateTimeBetween('-3 years', '-0 years'));
        $tanggal_pensiun = $is_pns ? now()->parse($tanggal_lahir)->addYear(60) : now()->parse(fake()->dateTimeBetween('-2 years', '1 years'));

        return [
            'nama' => fake()->unique()->firstName(($gender_kode = fake()->randomElement(GenderEnum::class)) == GenderEnum::LAKILAKI ? 'male' : 'female').' '.fake()->unique()->lastName(),
            'nik' => fake()->numerify('################'),
            'nuptk' => fake()->boolean(85) ? null : fake()->numerify('################'),
            'nip' => $is_asn ? null : fake()->numerify('##################'),
            'gender_kode' => $gender_kode,
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => $tanggal_lahir,
            'gelar_depan' => fake()->randomElement([null, 'H.', 'Prof.', 'Dr.']),
            'gelar_belakang' => fake()->randomElement([null, 'S.Pd', 'S.Pd.I']),
            'nomor_hp' => fake()->boolean(85) ? null : fake()->e164PhoneNumber(),
            'email' => fake()->boolean(85) ? null : fake()->unique()->safeEmail(),

            'jenjang_pendidikan_id' => JenjangPendidikan::inRandomOrder()->first() ?? JenjangPendidikanFactory::new()->create(),

            'status_kepegawaian_kode' => $status_kepegawaian_kode,
            'masa_kerja_tahun' => $is_asn ? fake()->randomDigitNotNull() : null,
            'masa_kerja_bulan' => $is_asn ? fake()->randomElement([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]) : null,

            'tmt_cpns' => $is_pns ? $tanggal_cpns : null,
            'tanggal_sk_cpns' => $is_pns ? $tanggal_cpns : null,
            'nomor_sk_cpns' => $is_pns ? fake()->numerify("801/Kep.###-BKPSDM/{$tanggal_cpns->year}") : null,

            'tmt_pns' => $is_asn && $tanggal_pns ? $tanggal_pns : null,
            'tanggal_sk_pns' => $is_asn && $tanggal_pns ? $tanggal_pns : null,
            'nomor_sk_pns' => $is_asn && $tanggal_pns ? fake()->numerify("802/Kep.###-BKPSDM/{$tanggal_pns->year}") : null,

            'golongan_kode' => $is_asn ? fake()->randomElement(GolonganAsnEnum::class) : null,
            'tmt_pangkat' => $is_asn ? $tanggal_pangkat : null,
            'tanggal_sk_pangkat' => $is_asn ? $tanggal_pangkat : null,
            'nomor_sk_pangkat' => $is_asn ? fake()->numerify("802/Kep.###-BKPSDM/{$tanggal_pangkat->year}") : null,

            'tmt_pensiun' => $tanggal_pensiun,
            'tanggal_sk_pensiun' => $is_pensiun ? $tanggal_pensiun : null,
            'nomor_sk_pensiun' => $is_pensiun ? fake()->numerify("802/Kep.###-BKPSDM/{$tanggal_pensiun->year}") : null,

            'sekolah_id' => ($sekolah = Sekolah::inRandomOrder()->first()) ?? ($sekolah = SekolahFactory::new())->create(),
            'status_tugas_kode' => fake()->randomElement(StatusTugasEnum::class),
            'jenis_ptk_id' => JenisPtk::inRandomOrder()->first() ?? JenisPtkFactory::new()->create(),
            'bidang_studi_pendidikan_id' => BidangStudiPendidikan::inRandomOrder()->first() ?? BidangStudiPendidikanFactory::new()->create(),
            'bidang_studi_sertifikasi_id' => BidangStudiSertifikasi::inRandomOrder()->first() ?? BidangStudiSertifikasiFactory::new()->create(),
            'mata_pelajaran_id' => MataPelajaran::where('jenjang_sekolah_id', $sekolah->jenjang_sekolah_id)->inRandomOrder()->first() ?? MataPelajaranFactory::new()->create(['jenjang_sekolah_id' => $sekolah->jenjang_sekolah_id]),
            'jam_mengajar_perminggu' => fake()->randomFloat(1, 30, 40),
            'is_kepsek' => $is_kepsek = ($is_pns ? fake()->boolean(25) : false),
            'is_plt_kepsek' => $is_pns && ! $is_kepsek ? fake()->boolean(25) : false,
        ];
    }
}
