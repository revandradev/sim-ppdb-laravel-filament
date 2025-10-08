<?php
namespace App\Providers\Filament;

use App\Settings\GeneralSetting;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use lockscreen\FilamentLockscreen\Http\Middleware\Locker;
use lockscreen\FilamentLockscreen\Lockscreen;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $setting = app(GeneralSetting::class);
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->profile(isSimple: false)
            ->login()
            ->globalSearch(true)
            ->sidebarCollapsibleOnDesktop()
            ->brandName($setting->site_name ?? 'Backoffice')
            // ->brandLogo($setting->site_logo ? asset('storage/' . $setting->site_logo) : null)
            ->brandLogoHeight('3rem')
            ->favicon($setting->site_favicon ? asset('storage/' . $setting->site_favicon) : null)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(app_path('Filament/Resources'), 'App\\Filament\\Resources')
            ->discoverPages(app_path('Filament/Pages'), 'App\\Filament\\Pages')
            ->pages([Dashboard::class])
            ->discoverWidgets(app_path('Filament/Widgets'), 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
                Locker::class,
            ])
            ->plugins([
                // StickyHeaderPlugin::make()
                //     ->floating(),
                FilamentShieldPlugin::make(),
                FilamentSocialitePlugin::make()
                    ->providers([
                        Provider::make('google')
                            ->icon('fab-google')
                            ->label('Google')
                            ->visible(true),
                    ])->registration(true),
                EasyFooterPlugin::make()
                    ->withSentence('revan.dev')
                    ->withLogo(
                        'https://static.cdnlogo.com/logos/l/23/laravel.svg', // Path to logo
                        'https://laravel.com',                               // URL for logo link (optional)
                        'dibuat dengan Laravel',                             // Text to display (optional)
                        24                                                   // Logo height in pixels (default: 20)
                    ),
                Lockscreen::make()
                    ->disableDisplayName()
                    ->enableIdleTimeout()
                    ->enableRateLimit()
                    ->enablePlugin(true),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
