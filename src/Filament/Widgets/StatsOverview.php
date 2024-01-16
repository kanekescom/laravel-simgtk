<?php

namespace Kanekescom\Simgtk\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Kanekescom\Simgtk\Models\Mutasi;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Pegawai Aktif', Pegawai::count()),
            Stat::make('Jumlah Sekolah Aktif', Sekolah::count()),
            Stat::make('Jumlah Usulan Mutasi', Mutasi::count()),
        ];
    }
}
