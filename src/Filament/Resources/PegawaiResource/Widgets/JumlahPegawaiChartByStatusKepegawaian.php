<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Arr;
use Kanekescom\Simgtk\Enums\StatusKepegawaianEnum;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Pegawai;

class JumlahPegawaiChartByStatusKepegawaian extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Status';

    protected static ?string $pollingInterval = '10s';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Pegawai',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => [
                        Pegawai::query()
                            ->aktif()
                            ->jenjangSekolahId($this->filter)
                            ->statusKepegawaianPns()
                            ->count(),
                        Pegawai::query()
                            ->aktif()
                            ->jenjangSekolahId($this->filter)
                            ->statusKepegawaianPppk()
                            ->count(),
                        Pegawai::query()
                            ->aktif()
                            ->jenjangSekolahId($this->filter)
                            ->statusKepegawaianNonAsn()
                            ->count(),
                    ],
                ],
                [
                    'label' => 'Guru',
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FFA07A',
                    'data' => [
                        Pegawai::query()
                            ->guruAktif()
                            ->jenjangSekolahId($this->filter)
                            ->statusKepegawaianPns()
                            ->count(),
                        Pegawai::query()
                            ->guruAktif()
                            ->jenjangSekolahId($this->filter)
                            ->statusKepegawaianPppk()
                            ->count(),
                        Pegawai::query()
                            ->guruAktif()
                            ->jenjangSekolahId($this->filter)
                            ->statusKepegawaianNonAsn()
                            ->count(),
                    ],
                ],
            ],
            'labels' => [
                StatusKepegawaianEnum::PNS->getLabel(),
                StatusKepegawaianEnum::PPPK->getLabel(),
                StatusKepegawaianEnum::NONASN->getLabel(),
            ],
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
