<?php

namespace Kanekescom\Simgtk\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Kanekescom\Simgtk\Models\UsulMutasi;

class UsulMutasiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new UsulMutasi([
            'id' => $row['id'],
            'rencana_mutasi_id' => $row['rencana_mutasi_id'],
            'pegawai_id' => $row['pegawai_id'],
            'asal_sekolah_id' => $row['asal_sekolah_id'],
            'asal_mata_pelajaran_id' => $row['asal_mata_pelajaran_id'],
            'tujuan_sekolah_id' => $row['tujuan_sekolah_id'],
            'tujuan_mata_pelajaran_id' => $row['tujuan_mata_pelajaran_id'],
        ]);
    }
}
