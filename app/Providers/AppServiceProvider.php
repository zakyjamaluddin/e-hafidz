<?php

namespace App\Providers;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::serving(function () {
        //     Filament::registerUserMenuItems([
        //         UserMenuItem::make()
        //             ->label('Keluar')
        //             ->icon('heroicon-o-arrow-left-on-rectangle')
        //             ->url(route('filament.admin.auth.logout')) // <-- pastikan route logout POST
        //             ->color('danger'),
        //     ]);
        // });
        
    }
}
