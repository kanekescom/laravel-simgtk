<?php

namespace Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Kanekescom\Simgtk\Models\JenjangSekolah;
use Kanekescom\Simgtk\Models\Pegawai;

class JumlahPegawaiChartByWilayah extends ChartWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $heading = 'Jumlah Pegawai Berdasarkan Wilayah';

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Pegawai::query()
            ->with('wilayah')
            ->whereHas('sekolah', function (Builder $query) {
                if (filled($this->filter)) {
                    $query->where('jenjang_sekolah_id', $this->filter);
                }
            })
            ->get()
            ->groupBy('wilayah.id')
            ->map(function ($group) {
                return [
                    'wilayah' => $group->first()?->wilayah?->nama,
                    'count' => $group->count(),
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $data->pluck('count'),
                ],
            ],
            'labels' => $data->pluck('wilayah'),
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
