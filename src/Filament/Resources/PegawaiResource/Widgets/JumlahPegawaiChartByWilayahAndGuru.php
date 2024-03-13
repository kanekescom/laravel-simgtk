<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Models\Wilayah;

class JumlahPegawaiChartByWilayahAndGuru extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Wilayah dan Guru';

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
                    'label' => 'Pegawai',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->pegawaiAktif()
                            ->count()
                    ),
                ],
                [
                    'label' => 'Guru',
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FFA07A',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->guruAktif()
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
