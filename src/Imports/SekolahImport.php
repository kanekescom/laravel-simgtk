<?php

namespace Kanekescom\Simgtk\Imports;

use Kanekescom\Simgtk\Models\JenjangSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Models\Sekolah;
use Kanekescom\Simgtk\Models\Wilayah;

class SekolahImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Sekolah([
            'id' => $row['id'],
            'nama' => $row['nama'],
            'npsn' => $row['npsn'],
            'jenjang_sekolah_id' => JenjangSekolah::where('nama', $row['jenjang_sekolah'])->first()->id,
            'wilayah_id' => Wilayah::where('nama', $row['wilayah'])->first()->id,
            'jumlah_kelas' => $row['jumlah_kelas'],
            'jumlah_rombel' => $row['jumlah_rombel'],
            'jumlah_siswa' => $row['jumlah_siswa'],
        ]);
    }
}
