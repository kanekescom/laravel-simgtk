<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\Pegawai;

class PegawaiChartByWilayahSekolah extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Kecamatan';

    protected static ?string $pollingInterval = '10s';

    protected function getData(): array
    {
        $data = Pegawai::query()
            ->countByWilayahSekolah()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $data->map(fn ($value) => $value->count),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->wilayahSekolah->getLabel()),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
