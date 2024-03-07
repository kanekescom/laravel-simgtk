<?php

namespace Kanekescom\Simgtk;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Kanekescom\Simgtk\Filament\Pages\Backups;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByGender;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByStatusKepegawaian;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByWilayah;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\JumlahSekolahChartByJenjangSekolah;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\JumlahSekolahChartByWilayah;

class SimgtkPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id(config('simgtk.filament.id'))
            ->path(config('simgtk.filament.path'))
            ->profile(isSimple: false)
            ->login()
            ->brandLogo(config('simgtk.filament.brandLogo'))
            ->favicon(config('simgtk.filament.favicon'))
            ->colors(config('simgtk.filament.colors'))
            ->topbar(config('simgtk.filament.topbar'))
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: __DIR__.'/Filament/Resources', for: 'Kanekescom\\Simgtk\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/Filament/Pages', for: 'Kanekescom\\Simgtk\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: __DIR__.'/Filament/Widgets', for: 'Kanekescom\\Simgtk\\Filament\\Widgets')
            ->widgets([
                JumlahPegawaiChartByStatusKepegawaian::class,
                JumlahPegawaiChartByGender::class,
                JumlahPegawaiChartByWilayah::class,
                JumlahSekolahChartByWilayah::class,
                JumlahSekolahChartByJenjangSekolah::class,
            ])
            ->navigationGroups(config('simgtk.filament.navigationGroups'))
            ->plugins([
                \ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(Backups::class),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
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
