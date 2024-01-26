<?php

namespace Kanekescom\Simgtk\Imports;

use Kanekescom\Simgtk\Models\JenjangSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Models\MataPelajaran;

class MataPelajaranImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new MataPelajaran([
            'id' => $row['id'],
            'jenjang_sekolah_id' => JenjangSekolah::where('kode', $row['jenjang_sekolah'])->first()->id,
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'singkatan' => $row['singkatan'],
        ]);
    }
}
