<?php

namespace Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets;

use Filament\Widgets\ChartWidget;
use Kanekescom\Simgtk\Enums\StatusSekolahEnum;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Sekolah;

class JumlahSekolahChartByJenjangSekolahAndStatus extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Sekolah Berdasarkan Jenjang dan Status';

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => JenjangSekolah::where('kode', 'sd')->first()?->nama,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => [
                        Sekolah::query()
                            ->jenjangSekolahSd()
                            ->statusNegeri()
                            ->count(),
                        Sekolah::query()
                            ->jenjangSekolahSd()
                            ->statusSwasta()
                            ->count(),
                    ],
                ],
                [
                    'label' => JenjangSekolah::where('kode', 'smp')->first()?->nama,
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FFA07A',
                    'data' => [
                        Sekolah::query()
                            ->jenjangSekolahSmp()
                            ->statusNegeri()
                            ->count(),
                        Sekolah::query()
                            ->jenjangSekolahSmp()
                            ->statusSwasta()
                            ->count(),
                    ],
                ],
            ],
            'labels' => [
                StatusSekolahEnum::NEGERI->getLabel(),
                StatusSekolahEnum::SWASTA->getLabel(),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
