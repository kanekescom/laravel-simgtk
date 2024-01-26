<?php

namespace Kanekescom\Simgtk\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Models\BidangStudiSertifikasi;

class BidangStudiSertifikasiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new BidangStudiSertifikasi([
            'id' => $row['id'],
            'nama' => $row['nama'],
        ]);
    }
}
