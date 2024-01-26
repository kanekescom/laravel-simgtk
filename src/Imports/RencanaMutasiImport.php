<?php

namespace Kanekescom\Simgtk\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Models\RencanaMutasi;

class RencanaMutasiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new RencanaMutasi([
            'id' => $row['id'],
            'nama' => $row['nama'],
            'tanggal_mulai' => now()->parse($row['tanggal_mulai']),
            'tanggal_berakhir' => now()->parse($row['tanggal_berakhir']),
            'is_aktif' => (bool) $row['is_aktif'],
        ]);
    }
}
