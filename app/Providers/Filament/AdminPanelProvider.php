<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Awcodes\FilamentVersions\VersionsPlugin;
use Awcodes\FilamentVersions\VersionsWidget;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use App\Filament\Pages\BackupPage;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use App\Filament\Pages\HealthPage;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->theme(asset('css/filament/admin/theme.css'))
            ->id('admin')
            ->path('admin')
            ->brandName('Dashboard des THEMATIQUEs')
             ->favicon(asset('images/ifdd.png'))
             ->plugin(FilamentProgressbarPlugin::make()->color('#70af85'))
             ->plugin(FilamentSpatieLaravelBackupPlugin::make()->usingPage(BackupPage::class))
             ->plugin(FilamentSpatieLaravelHealthPlugin::make()->usingPage(HealthPage::class))
          /*  ->plugin(
                FilamentLaravelLogPlugin::make()
                ->navigationGroup('Paramètres')
                ->navigationLabel('Logs')
               
            )*/
             ->plugins([
        EnvironmentIndicatorPlugin::make(),
             ])
     
            ->login()
            ->colors([
                'primary' => "#2781d6", // couleur par défaut #70af85
            ])
               ->plugins([
            OverlookPlugin::make()
              ->excludes([
                    \App\Filament\Resources\UserResource::class,
                ])
            ->alphabetical()
                ->sort(1)
                ->columns([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 5,
                    '2xl' => null,
                ]),
              // VersionsPlugin::make()->hasNavigationView(false),
        ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                 OverlookWidget::class,
                // VersionsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\PageViewsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\VisitorsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersOneDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersSevenDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersTwentyEightDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsDurationWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsByCountryWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsByDeviceWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\MostVisitedPagesWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\TopReferrersListWidget::class,
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
