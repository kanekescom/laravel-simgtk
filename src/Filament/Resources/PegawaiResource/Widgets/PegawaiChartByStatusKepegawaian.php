<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\Pegawai;

class PegawaiChartByStatusKepegawaian extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Status Kepegawaian';

    protected static ?string $pollingInterval = '10s';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Pegawai::query()
            ->countGroupByStatusKepegawaian()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $data->map(fn ($value) => $value->count),
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->status_kepegawaian_kode->getLabel()),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
