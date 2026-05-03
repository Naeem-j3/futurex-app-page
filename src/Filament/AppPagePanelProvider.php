<?php

namespace FutureX\AppPage\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use FutureX\AppPage\Filament\Resources\AppPageResource;

// middleware imports
use FutureX\AppPage\Filament\Widgets\AppPageVisitsChart;
use FutureX\AppPage\Filament\Widgets\ClicksChart;
use FutureX\AppPage\Filament\Widgets\DeviceChart;
use FutureX\AppPage\Filament\Widgets\TopCountriesChart;
use FutureX\AppPage\Filament\Widgets\UserState;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;

// filament middleware
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use FutureX\AppPage\Filament\Widgets\AppPageStats;
use Filament\Pages\Dashboard;
class AppPagePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app-page')
            ->path('app-panel')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->resources([
                AppPageResource::class,
            ])
            ->pages([
                \Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                AppPageStats::class,
                AppPageVisitsChart::class,
                ClicksChart::class,
                DeviceChart::class,
                TopCountriesChart::class,
                UserState::class
            ])
            // 🔥 هذا هو الحل
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
                \FutureX\AppPage\Http\Middleware\AuthorizeAdmin::class,
            ]);
    }
}
