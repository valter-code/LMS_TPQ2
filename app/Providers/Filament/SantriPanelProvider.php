<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\View;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\Santri\Widgets\KelasDiikutiWidget;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Filament\Santri\Widgets\AbsensiSantriMandiriWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class SantriPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('santri')
            ->path('santri')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->colors([ // Definisikan warna primer di sini
                'primary' => Color::Teal, // Atau Color::Green jika lebih cocok, atau hex code
                // Anda juga bisa mendefinisikan danger, gray, info, success, warning
                // 'danger' => Color::Rose,
                // 'gray' => Color::Gray,
                // 'info' => Color::Blue,
                // 'success' => Color::Emerald,
                // 'warning' => Color::Amber,
            ])
            // ->viteTheme('resources/css/filament/santri/theme.css') // Path ke file sumber di resources/
            // ->theme(asset('css/filament/santri/theme.css')) // Path ke file theme
            ->discoverResources(in: app_path('Filament/Santri/Resources'), for: 'App\\Filament\\Santri\\Resources')
            ->discoverPages(in: app_path('Filament/Santri/Pages'), for: 'App\\Filament\\Santri\\Pages')
            ->pages([
                Pages\Dashboard::class,
                
            ])
            ->discoverWidgets(in: app_path('Filament/Santri/Widgets'), for: 'App\\Filament\\Santri\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                AbsensiSantriMandiriWidget::class,
                KelasDiikutiWidget::class,
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

    
//     public function boot(): void
// {
//     Filament::serving(function () {
//         // Pastikan Anda mengimport Filament facade jika belum: use Filament\Facades\Filament;
//         // Dan juga View facade: use Illuminate\Support\Facades\View;

//         Filament::registerRenderHook(
//             // Hook yang lebih baik untuk CSS adalah 'panels::head.end' agar masuk di <head>
//             // atau 'panels::styles.after'
//             'panels::head.end', 
//             fn (): string => View::make('filament.custom-styles')->render()
//         );
//     });
// }

public function boot(): void
{
    Filament::serving(function () {
        Filament::registerRenderHook(
            // Hook 'panels::styles.after' lebih baik untuk menyisipkan <style>
            // atau 'panels::head.end'
            'panels::styles.after', 
            fn (): string => View::make('filament.custom-styles')->render()
        );
    });
}

    
}
