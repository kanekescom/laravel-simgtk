<?php

namespace Kanekescom\Simgtk;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\PegawaiChartByGender;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\PegawaiChartByStatusKepegawaian;
// use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\PegawaiChartByWilayahSekolah;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\SekolahChartByJenjangSekolah;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\SekolahChartByWilayah;
use Kanekescom\Simgtk\Filament\Widgets\StatsOverview;

class SimgtkPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('simgtk')
            ->path('simgtk')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: __DIR__.'/Filament/Resources', for: 'Kanekescom\\Simgtk\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/Filament/Pages', for: 'Kanekescom\\Simgtk\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: __DIR__.'/Filament/Widgets', for: 'Kanekescom\\Simgtk\\Filament\\Widgets')
            ->widgets([
                StatsOverview::class,
                PegawaiChartByStatusKepegawaian::class,
                PegawaiChartByGender::class,
                // PegawaiChartByWilayahSekolah::class,
                SekolahChartByJenjangSekolah::class,
                SekolahChartByWilayah::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
