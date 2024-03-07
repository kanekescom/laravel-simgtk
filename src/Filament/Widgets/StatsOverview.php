<?php

namespace Kanekescom\Simgtk\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Kanekescom\Simgtk\Models\Pegawai;
use Kanekescom\Simgtk\Models\Sekolah;

class StatsOverview extends BaseWidget
{
    use \BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

    protected static ?string $pollingInterval = '10s';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Pegawai', Pegawai::aktif()->count()),
            Stat::make('Jumlah Guru', Pegawai::guruAktif()->count()),
            Stat::make('Jumlah Sekolah', Sekolah::count()),
        ];
    }
}
