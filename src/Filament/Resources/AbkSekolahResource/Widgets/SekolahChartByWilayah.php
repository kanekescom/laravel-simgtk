<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\Sekolah;

class SekolahChartByWilayah extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Sekolah Berdasarkan Wilayah';

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Sekolah::query()
            ->countByWilayah()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sekolah',
                    'data' => $data->map(fn ($value) => $value->count),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->wilayah->nama),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
