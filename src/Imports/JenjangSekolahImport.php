<?php

namespace Kanekescom\Simgtk\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Models\JenjangSekolah;

class JenjangSekolahImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new JenjangSekolah([
            'id' => $row['id'],
            'kode' => $row['kode'],
            'nama' => $row['nama'],
        ]);
    }
}
