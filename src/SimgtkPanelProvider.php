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
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByGender;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByJenjangPendidikan;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByStatusKepegawaian;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByWilayahAndGuru;
use Kanekescom\Simgtk\Filament\Resources\PegawaiResource\Widgets\JumlahPegawaiChartByWilayahAndStatusKepegawaian;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\JumlahSekolahChartByJenjangSekolahAndStatus;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\JumlahSekolahChartByWilayahAndJenjangSekolah;
use Kanekescom\Simgtk\Filament\Resources\SekolahResource\Widgets\JumlahSekolahChartByWilayahAndStatus;

class SimgtkPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('simgtk')
            ->path(config('simgtk.filament.path'))
            ->domain(config('simgtk.filament.domain'))
            ->profile(isSimple: false)
            ->login()
            ->brandName(config('simgtk.filament.brandName'))
            ->brandLogo(config('simgtk.filament.brandLogo'))
            ->brandLogoHeight(config('simgtk.filament.brandLogoHeight'))
            ->favicon(config('simgtk.filament.favicon'))
            ->colors(config('simgtk.filament.colors'))
            ->darkMode(config('simgtk.filament.darkMode.enabled'))
            ->topbar(config('simgtk.filament.topbar.enabled'))
            ->topNavigation(config('simgtk.filament.topNavigation.enabled'))
            ->breadcrumbs(config('simgtk.filament.breadcrumbs.enabled'))
            ->databaseNotifications(config('simgtk.filament.databaseNotifications.enabled'))
            ->databaseNotificationsPolling(config('simgtk.filament.databaseNotifications.polling'))
            ->spa(config('simgtk.filament.spa.enabled'))
            ->unsavedChangesAlerts(config('simgtk.filament.unsavedChangesAlerts.enabled'))
            ->databaseTransactions(config('simgtk.filament.databaseTransactions.enabled'))
            ->sidebarCollapsibleOnDesktop(config('simgtk.filament.sidebarCollapsibleOnDesktop.enabled'))
            ->sidebarFullyCollapsibleOnDesktop(config('simgtk.filament.sidebarFullyCollapsibleOnDesktop.enabled'))
            ->navigation(config('simgtk.filament.navigation.enabled'))
            ->collapsibleNavigationGroups(config('simgtk.filament.collapsibleNavigationGroups.enabled'))
            ->navigationGroups(config('simgtk.filament.navigationGroups'))
            ->discoverResources(in: __DIR__.'/Filament/Resources', for: 'Kanekescom\\Simgtk\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/Filament/Pages', for: 'Kanekescom\\Simgtk\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: __DIR__.'/Filament/Widgets', for: 'Kanekescom\\Simgtk\\Filament\\Widgets')
            ->widgets([
                JumlahPegawaiChartByStatusKepegawaian::class,
                JumlahPegawaiChartByGender::class,
                JumlahPegawaiChartByJenjangPendidikan::class,
                JumlahPegawaiChartByWilayahAndGuru::class,
                JumlahPegawaiChartByWilayahAndStatusKepegawaian::class,
                JumlahSekolahChartByJenjangSekolahAndStatus::class,
                JumlahSekolahChartByWilayahAndStatus::class,
                JumlahSekolahChartByWilayahAndJenjangSekolah::class,
            ])
            ->plugins([
                \ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(\Kanekescom\Simgtk\Filament\Pages\Backups::class),
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
