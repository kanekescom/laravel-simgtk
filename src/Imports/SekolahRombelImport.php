<?php

namespace Kanekescom\Simgtk\Imports;

use Illuminate\Support\Arr;
use Kanekescom\Simgtk\Models\Sekolah;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class SekolahRombelImport implements ToModel, WithHeadingRow, WithProgressBar
{
    use Importable;

    public function headingRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $row = Arr::map($row, function ($value) {
            $cleanedString = preg_replace('/[^\p{L}\p{N}\p{P}\p{S}\s]/u', '', $value);

            return $cleanedString === 'null' ? null : $cleanedString;
        });

        $model = Sekolah::where('npsn', $row[self::getField('NPSN')]);
        $model->update([
            'jumlah_kelas' => $row[self::getField('R. Kelas')],
            'jumlah_rombel' => $row[self::getField('Rombel')],
            'jumlah_siswa' => $row[self::getField('PD')],
            'sd_kelas_abk' => $row[self::getField('R. Kelas')],
        ]);

        return $model->first();
    }

    protected static function getField($var): string|null
    {
        return str($var)->slug('_');
    }
}
