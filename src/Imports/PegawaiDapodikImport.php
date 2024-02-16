<?php

namespace Kanekescom\Simgtk\Imports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kanekescom\Simgtk\Enums\GenderEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnEnum;
use Kanekescom\Simgtk\Enums\GolonganAsnLabelEnum;
use Kanekescom\Simgtk\Enums\JenjangPendidikanEnum;
use Kanekescom\Simgtk\Enums\JenjangPendidikanLabelEnum;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Enums\StatusTugasEnum;
use Kanekescom\Simgtk\Enums\StatusTugasLabelEnum;
use Kanekescom\Simgtk\Models\BidangStudiPendidikan;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;
use Kanekescom\Simgtk\Models\JenisPtk;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\MataPelajaran;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\Wilayah;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Spatie\LaravelOptions\Options;

class PegawaiDapodikImport implements ToModel, WithHeadingRow, WithProgressBar
{
    use Importable;

    public function model(array $row)
    {
        $row = Arr::map($row, function ($value) {
            $cleanedString = preg_replace('/[^\p{L}\p{N}\p{P}\p{S}\s]/u', '', $value);

            return $cleanedString === 'null' ? null : $cleanedString;
        });

        if (!str($row[self::getField('Tempat Tugas')])->startsWith(['SDN ', 'SMPN '])) {
            return null;
        }

        $pegawai = Pegawai::where('nik', $row[self::getField('NIK')])->first();
        $pegawai_status_tugas_kode = self::getEnumStatusTugasGetValue($row[self::getField('Status Tugas')]);

        if ($pegawai?->status_tugas_kode == (StatusTugasEnum::INDUK)->value) {
            return null;
        }

        return Pegawai::updateOrCreate(['nik' => $row[self::getField('NIK')]], [
            // 'id' => $row[self::getField('id')],
            'nama' => str($row[self::getField('Nama')])->upper()->value,
            'nik' => $row[self::getField('NIK')],
            'nuptk' => $row[self::getField('NUPTK')],
            'nip' => $row[self::getField('NIP')],
            'gender_kode' => self::getEnumValueByLabel(GenderEnum::class, $row[self::getField('L/P')]),
            'tempat_lahir' => str($row[self::getField('Tempat Lahir')])->upper()->value,
            'tanggal_lahir' => $row[self::getField('Tanggal Lahir')],
            // 'gelar_depan' => $row[self::getField('gelar_depan')],
            // 'gelar_belakang' => $row[self::getField('gelar_belakang')],
            'nomor_hp' => $row[self::getField('Nomor HP')],
            // 'email' => $row[self::getField('email')],
            'jenjang_pendidikan_kode' => self::getEnumJenjangPendidikanGetValue($row[self::getField('Pendidikan')]),
            'status_kepegawaian_kode' => self::getEnumStatusKepegawaianGetValue($row[self::getField('Status Kepegawaian')]),
            'masa_kerja_tahun' => $row[self::getField('Masa Kerja Tahun')],
            'masa_kerja_bulan' => $row[self::getField('Masa Kerja Bulan')],
            'tmt_cpns' => $row[self::getField('Tanggal CPNS')],
            'tanggal_sk_cpns' => $row[self::getField('Tanggal CPNS')],
            'nomor_sk_cpns' => $row[self::getField('SK CPNS')],
            'tmt_pns' => $row[self::getField('TMT Pengangkatan')],
            'tanggal_sk_pns' => $row[self::getField('TMT Pengangkatan')],
            'nomor_sk_pns' => $row[self::getField('SK Pengangkatan')],
            'golongan_kode' => self::getEnumGolonganAsnGetValue($row[self::getField('Pangkat/Gol')]),
            'tmt_pangkat' => $row[self::getField('TMT Pangkat')],
            'tanggal_sk_pangkat' => $row[self::getField('TMT Pangkat')],
            // 'nomor_sk_pangkat' => $row[self::getField('nomor_sk_pangkat')],
            'tmt_pensiun' => now()->parse($row[self::getField('Tanggal Lahir')])->addYear(60)->addMonth(1)->firstOfMonth()->toDateString(),
            // 'tanggal_sk_pensiun' => $row[self::getField('tanggal_sk_pensiun')],
            // 'nomor_sk_pensiun' => $row[self::getField('nomor_sk_pensiun')],
            'sekolah_id' => self::getSekolah($row)?->id,
            'status_tugas_kode' => $pegawai_status_tugas_kode,
            'jenis_ptk_id' => self::getJenisPtk($row[self::getField('Jenis PTK')])?->id,
            'bidang_studi_pendidikan_id' => self::getBidangStudiPendidikan($row[self::getField('Bidang Studi Pendidikan')])?->id,
            'bidang_studi_sertifikasi_id' => self::getBidangStudiSertifikasi($row[self::getField('Bidang Studi Sertifikasi')])?->id,
            'mata_pelajaran_id' => self::getMataPelajaran($row)?->id,
            'jam_mengajar_perminggu' => $row[self::getField('Jam Mengajar Perminggu')],
            'is_kepsek' => $row[self::getField('Jabatan Kepsek')] == 'Ya',
            // 'is_plt_kepsek' => $row[self::getField('is_plt_kepsek')] == 'Ya',
        ]);
    }

    protected static function getField($var): string|null
    {
        return str($var)->lower()->remove('/')->snake();
    }

    protected static function getEnumStatusKepegawaianGetValue($nama): string|null
    {
        return self::getEnumValueByLabel(StatusKepegawaianEnum::class, $nama == 'CPNS' ? 'PNS' : $nama) ?? (StatusKepegawaianEnum::NONASN)->value;
    }

    protected static function getMataPelajaran($row): Model|null
    {
        $jenjang_sekolah_id = $row[self::getField('Tempat Tugas')];
        $nama = $row[self::getField('mata Pelajaran Diajarkan')];

        if ($nama) {
            return MataPelajaran::updateOrCreate([
                'jenjang_sekolah_id' => self::getJenjangSekolah($jenjang_sekolah_id)?->id,
                'nama' => $nama,
            ], [
                'jenjang_sekolah_id' => self::getJenjangSekolah($jenjang_sekolah_id)?->id,
                'nama' => $nama,
            ]);
        }

        return null;
    }

    protected static function getBidangStudiPendidikan($nama): Model|null
    {
        if ($nama) {
            return BidangStudiPendidikan::updateOrCreate(['nama' => $nama], ['nama' => $nama]);
        }

        return null;
    }

    protected static function getBidangStudiSertifikasi($nama): Model|null
    {
        if ($nama) {
            return BidangStudiSertifikasi::updateOrCreate(['nama' => $nama], ['nama' => $nama]);
        }

        return null;
    }

    protected static function getJenisPtk($nama): Model|null
    {
        if ($nama) {
            return JenisPtk::updateOrCreate(['nama' => $nama], ['nama' => $nama]);
        }

        return null;
    }

    protected static function getJenjangSekolah($nama): Model|null
    {
        $sd = str($nama)->startsWith(['SDN ']);
        $smp = str($nama)->startsWith(['SMPN ']);

        if ($sd) {
            return JenjangSekolah::where('nama', 'SD')->first();
        }

        if ($smp) {
            return JenjangSekolah::where('nama', 'SMP')->first();
        }

        return null;
    }

    protected static function getWilayah($nama): Model|null
    {
        if ($nama) {
            return Wilayah::updateOrCreate(['nama' => $nama], ['nama' => $nama]);
        }

        return null;
    }

    protected static function getSekolah($row): Model
    {
        return Sekolah::updateOrCreate(['npsn' => $row[self::getField('NPSN')]], [
            'nama' => $row[self::getField('Tempat Tugas')],
            'jenjang_sekolah_id' => self::getJenjangSekolah($row[self::getField('Tempat Tugas')])?->id,
            'wilayah_id' => self::getWilayah($row[self::getField('Kecamatan')])?->id,
        ]);
    }

    protected static function getEnumLabelValue($enum): Collection
    {
        return collect(Options::forEnum($enum)->toArray())->pluck('value', 'label');
    }

    protected static function getEnumValueLabel($enum): Collection
    {
        return collect(Options::forEnum($enum)->toArray())->pluck('label', 'value');
    }

    protected static function getEnumValueByLabel($enum, $key, $toLower = true): string|null
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

    protected static function getEnumStatusTugasGetValue($key): string|null
    {
        return self::getEnumLabelValue(StatusTugasEnum::class)->get(
            collect(Options::forEnum(StatusTugasLabelEnum::class)->toArray())->pluck('label', 'value')->get($key)
        );
    }
}
