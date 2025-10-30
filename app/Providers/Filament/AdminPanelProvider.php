<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\LoginCustom;
use App\Models\Tenant;
use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Facades\Filament;
use Filament\Http\Livewire\Auth\Login;
use Filament\Http\Middleware\AuthenticateSession;
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
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;
use Filament\Support\Facades\FilamentView;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(LoginCustom::class)
            ->colors([
                'primary' => Color::Green,
            ])
            ->favicon(asset('quran.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
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
            ->navigationItems([
                NavigationItem::make('Petunjuk Aplikasi')
                    ->url('https://docs.google.com/document/d/1PCX9Df6FxRsc1FdUY_1TqJZDxnZVsjjbjNfhyhEIWE8/edit?tab=t.0#heading=h.rmh5y2mdesur', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-question-mark-circle')
                    ->group('Dokumentasi'),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }




    public function boot(): void
    {
        // 🔹 Bagian HEAD (manifest, meta, dsb.)
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn (): string => <<<'HTML'
                <meta name="theme-color" content="#ffffffff" id="theme-color-meta"/>
                <link rel="apple-touch-icon" href="logo.png">
                <link rel="manifest" href="/manifest.json">
            HTML,
        );

        // 🔹 Bagian sebelum </body> (register service worker)
        FilamentView::registerRenderHook(
            'panels::body.end',
            fn (): string => <<<'HTML'
                <script src="/sw.js"></script>
                <script>
                    if ("serviceWorker" in navigator) {
                        // Register a service worker hosted at the root of the
                        // site using the default scope.
                        navigator.serviceWorker.register("/sw.js").then(
                        (registration) => {
                            console.log("Service worker registration succeeded:", registration);
                        },
                        (error) => {
                            console.error(`Service worker registration failed hehehe: ${error}`);
                        },
                        );
                    } else {
                        console.error("Service workers are not supported.");
                    }
                </script>
                <script>
                    const metaThemeColor = document.getElementById('theme-color-meta');

                    function updateThemeColor() {
                        if (!metaThemeColor) return;

                        const isDark = document.documentElement.classList.contains('dark');

                        if (isDark) {
                            metaThemeColor.setAttribute('content', '#18181b'); // hitam untuk dark mode
                        } else {
                            metaThemeColor.setAttribute('content', '#ffffff'); // putih untuk light mode
                        }
                    }

                    // Jalankan saat load
                    updateThemeColor();

                    // Jalankan saat user toggle tema di Filament
                    document.addEventListener('DOMContentLoaded', () => {
                        const toggleButton = document.querySelector('[data-toggle-theme]');
                        if (toggleButton) {
                            toggleButton.addEventListener('click', () => {
                                // delay sebentar supaya class dark sudah diterapkan
                                setTimeout(updateThemeColor, 50);
                            });
                        }
                    });

                    // Optional: observasi perubahan class dark untuk lebih robust
                    const observer = new MutationObserver(updateThemeColor);
                    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
                </script>
                 <script src="pwa-install.js"></script>

            HTML,
        );
    }



}
