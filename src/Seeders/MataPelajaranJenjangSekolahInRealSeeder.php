<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\MataPelajaranJenjangSekolah;

class MataPelajaranJenjangSekolahInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($jenjangSekolahValue, $jenjangSekolahKey) {
            $jenjangSekolah = JenjangSekolah::where('nama', $jenjangSekolahKey)->first();

            $jenjangSekolahValue->each(function ($mataPelajaranValue) use ($jenjangSekolah) {
                $mataPelajaran = MataPelajaran::where('nama', $mataPelajaranValue)->first();

                if ($jenjangSekolah && $mataPelajaran) {
                    MataPelajaranJenjangSekolah::create([
                        'jenjang_sekolah_id' => $jenjangSekolah->id,
                        'mata_pelajaran_id' => $mataPelajaran->id,
                    ]);
                }
            });
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            'SD' => collect([
                'Guru Kelas SD/MI/SLB',
                'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'Pendidikan Agama Islam',
            ]),

            'SMP' => collect([
                'Pendidikan Agama Islam',
                'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'Ilmu Pengetahuan Alam (IPA)',
                'Ilmu Pengetahuan Sosial (IPS)',
                'Matematika (Umum)',
                'Pendidikan Pancasila dan Kewarganegaraan',
                'Prakarya',
                'Seni dan Budaya',
                'Muatan Lokal Bahasa Daerah',
                'Prakarya',
            ]),
        ]);
    }
}
