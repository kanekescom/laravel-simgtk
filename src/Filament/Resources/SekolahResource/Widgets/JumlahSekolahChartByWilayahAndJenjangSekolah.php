<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Wilayah;

class JumlahSekolahChartByWilayahAndJenjangSekolah extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Sekolah Berdasarkan Wilayah dan Jenjang Sekolah';

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Wilayah::query()
            ->with('sekolah')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => JenjangSekolah::where('kode', 'sd')->first()?->nama,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->sekolah()
                            ->jenjangSekolahSd()
                            ->count()
                    ),
                ],
                [
                    'label' => JenjangSekolah::where('kode', 'smp')->first()?->nama,
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FFA07A',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->sekolah()
                            ->jenjangSekolahSmp()
                            ->count()
                    ),
                ],
            ],
            'labels' => $data->pluck('nama'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
