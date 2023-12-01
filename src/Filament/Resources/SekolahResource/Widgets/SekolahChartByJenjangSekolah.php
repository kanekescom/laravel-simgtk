<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\Sekolah;

class SekolahChartByJenjangSekolah extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Sekolah Berdasarkan Jenjang Sekolah';

    protected static ?string $pollingInterval = '10s';

    protected function getData(): array
    {
        $data = Sekolah::query()
            ->countByJenjangSekolah()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sekolah',
                    'data' => $data->map(fn ($value) => $value->count),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->jenjangSekolah->nama),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
