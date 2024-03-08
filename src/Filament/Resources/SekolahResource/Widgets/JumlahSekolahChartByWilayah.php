<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Arr;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

class JumlahSekolahChartByWilayah extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Sekolah Berdasarkan Wilayah';

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Sekolah::query()
            ->countGroupByWilayah($this->filter)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sekolah',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
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

    protected function getFilters(): ?array
    {
        return Arr::prepend(JenjangSekolah::pluck('nama', 'id')->toArray(), 'All', '');
    }
}
