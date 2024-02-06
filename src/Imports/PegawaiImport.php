<?php

namespace Kanekescom\Simgtk\Imports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnLabelEnum;
use Kanekescom\Simgtk\Enums\JenjangPendidikanEnum;
use Kanekescom\Simgtk\Enums\JenjangPendidikanLabelEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;
use Kanekescom\Simgtk\Models\JenisPtk;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\Wilayah;
use Spatie\LaravelOptions\Options;

class PegawaiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pegawai([
            // 'id' => $row['id'],
            'nama' => $row['nama'],
            'nik' => $row['nik'],
            'nuptk' => $row['nuptk'],
            'nip' => $row['nip'],
            'gender_kode' => self::getEnumGetValue(GenderEnum::class, $row['gender_kode']),
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'gelar_depan' => $row['gelar_depan'],
            'gelar_belakang' => $row['gelar_belakang'],
            'nomor_hp' => $row['nomor_hp'],
            'email' => $row['email'],
            'jenjang_pendidikan_kode' => self::getEnumJenjangPendidikanGetValue($row['jenjang_pendidikan_kode']),
            'status_kepegawaian_kode' => self::getEnumGetValue(StatusKepegawaianEnum::class, $row['status_kepegawaian_kode']) ?? StatusKepegawaianEnum::NONASN,
            'masa_kerja_tahun' => $row['masa_kerja_tahun'],
            'masa_kerja_bulan' => $row['masa_kerja_bulan'],
            'tmt_cpns' => $row['tmt_cpns'],
            'tanggal_sk_cpns' => $row['tanggal_sk_cpns'],
            'nomor_sk_cpns' => $row['nomor_sk_cpns'],
            'tmt_pns' => $row['tmt_pns'],
            'tanggal_sk_pns' => $row['tanggal_sk_pns'],
            'nomor_sk_pns' => $row['nomor_sk_pns'],
            'golongan_kode' => self::getEnumGolonganAsnGetValue($row['golongan_kode']),
            'tmt_pangkat' => $row['tmt_pangkat'],
            'tanggal_sk_pangkat' => $row['tanggal_sk_pangkat'],
            'nomor_sk_pangkat' => $row['nomor_sk_pangkat'],
            'tmt_pensiun' => $row['tmt_pensiun'],
            'tanggal_sk_pensiun' => $row['tanggal_sk_pensiun'],
            'nomor_sk_pensiun' => $row['nomor_sk_pensiun'],
            'sekolah_id' => self::getSekolah($row),
            'status_tugas_kode' => self::getEnumGetValue(StatusTugasEnum::class, $row['status_tugas_kode']),
            'jenis_ptk_id' => JenisPtk::where('nama', $row['jenis_ptk_id'])->first()?->id,
            'bidang_studi_pendidikan_id' => BidangStudiPendidikan::where('nama', $row['bidang_studi_pendidikan_id'])->first()?->id,
            'bidang_studi_sertifikasi_id' => BidangStudiSertifikasi::where('nama', $row['bidang_studi_sertifikasi_id'])->first()?->id,
            'mata_pelajaran_id' => MataPelajaran::where('nama', $row['mata_pelajaran_id'])->first()?->id,
            'jam_mengajar_perminggu' => $row['jam_mengajar_perminggu'],
            'is_kepsek' => $row['is_kepsek'] == 'Ya',
            'is_plt_kepsek' => $row['is_plt_kepsek'] == 'Ya',
        ]);
    }

    protected static function getSekolah($row): Model
    {
        return Sekolah::where('nama', $row['sekolah_id'])->where('wilayah_id', Wilayah::where('nama', $row['wilayah_id'])->first()->id)->first();
    }

    protected static function getEnumLabelValue($enum): Collection
    {
        return collect(Options::forEnum($enum)->toArray())->pluck('value', 'label');
    }

    protected static function getEnumValueLabel($enum): Collection
    {
        return collect(Options::forEnum($enum)->toArray())->pluck('label', 'value');
    }

    protected static function getEnumGetValue($enum, $key, $toLower = true): string|null
    {
        if ($toLower) {
            $key = str($key)->lower()->value;
        }

        return self::getEnumLabelValue($enum)->get(
            collect(Options::forEnum($enum)->toArray())->pluck('label', 'value')->get($key)
        );
    }

    protected static function getEnumGolonganAsnGetValue($key): string|null
    {
        return self::getEnumLabelValue(GolonganAsnEnum::class)->get(
            collect(Options::forEnum(GolonganAsnLabelEnum::class)->toArray())->pluck('label', 'value')->get($key)
        );
    }

    protected static function getEnumJenjangPendidikanGetValue($key): string|null
    {
        return self::getEnumLabelValue(JenjangPendidikanEnum::class)->get(
            collect(Options::forEnum(JenjangPendidikanLabelEnum::class)->toArray())->pluck('label', 'value')->get($key)
        );
    }
}
