<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\StatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Filament\Navigation\MenuItem;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id("admin")
            ->path("admin")
            ->login()
            ->colors([
                "primary" => Color::hex("#313575"),
                "secondary" => Color::hex("#E8A202"),
                "danger" => Color::hex("#B50038"),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth("15rem")

            ->theme(asset("css/filament/admin/theme.css"))

            ->brandName("SMANeka Admin")
            ->brandLogo(fn() => view("filament.brand-logo"))
            ->darkMode(true)
            ->maxContentWidth(MaxWidth::Full)
            ->favicon(fn() => setting('favicon') ? asset('storage/' . setting('favicon')) : asset('assets/img/favicon.png'))
            ->renderHook('panels.body.start', fn () => '
                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
            ')

            ->discoverResources(
                in: app_path("Filament/Resources"),
                for: "App\\Filament\\Resources",
            )
            ->discoverPages(
                in: app_path("Filament/Pages"),
                for: "App\\Filament\\Pages",
            )
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\Account::class,
                \App\Filament\Pages\ManageSettings::class,
            ])
            ->discoverWidgets(
                in: app_path("Filament/Widgets"),
                for: "App\\Filament\\Widgets",
            )
            ->widgets([
                StatsOverview::class,
                \App\Filament\Widgets\PostsStats::class,
                \App\Filament\Widgets\PopularPostsChart::class,
                \App\Filament\Widgets\ViewsPerMonthChart::class,
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([Authenticate::class])
            ->userMenuItems([
                'account' => MenuItem::make()
                    ->label('Pengaturan Akun')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->url(fn () => \App\Filament\Pages\Account::getUrl()),
            ]);
    }
}
