<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\Sekolah;

class JumlahSekolahChartByJenjangSekolah extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Sekolah Berdasarkan Jenjang';

    protected static ?string $pollingInterval = '10s';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Sekolah::query()
            ->countGroupByJenjangSekolah($this->filter)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sekolah',
                    'backgroundColor' => '#FFA500',
                    'borderColor' => '#FFD700',
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
