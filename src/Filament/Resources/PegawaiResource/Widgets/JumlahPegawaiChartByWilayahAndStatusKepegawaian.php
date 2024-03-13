<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Models\Wilayah;

class JumlahPegawaiChartByWilayahAndStatusKepegawaian extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Wilayah dan Status';

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
                    'label' => StatusKepegawaianEnum::PNS->getLabel(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->pegawaiAktif()
                            ->StatusKepegawaianPns()
                            ->count()
                    ),
                ],
                [
                    'label' => StatusKepegawaianEnum::PPPK->getLabel(),
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FFA07A',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->pegawaiAktif()
                            ->StatusKepegawaianPppk()
                            ->count()
                    ),
                ],
                [
                    'label' => StatusKepegawaianEnum::NONASN->getLabel(),
                    'backgroundColor' => '#FFA500',
                    'borderColor' => '#FF8C00',
                    'data' => $data->map(
                        fn ($value) => $value
                            ->pegawaiAktif()
                            ->StatusKepegawaianNonAsn()
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
