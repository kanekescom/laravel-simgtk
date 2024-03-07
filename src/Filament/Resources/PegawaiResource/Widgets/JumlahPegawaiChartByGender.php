<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Arr;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Pegawai;

class JumlahPegawaiChartByGender extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Gender';

    protected static ?string $pollingInterval = '10s';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Pegawai::query();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $data->aktif()
                        ->countGroupByGender($this->filter)
                        ->get()
                        ->map(fn ($value) => $value->count),
                ],
                [
                    'label' => 'Jumlah Guru',
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FFA07A',
                    'data' => $data->guruAktif()
                        ->countGroupByGender($this->filter)
                        ->get()
                        ->map(fn ($value) => $value->count),
                ],
            ],
            'labels' => $data->aktif()
                ->get()
                ->map(fn ($value) => $value->gender_kode->getLabel()),
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
