<?php

namespace App\Providers\Filament;

use App\Http\Middleware\AdminOnly;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName('ActiveHub')
            ->darkMode(false)
            ->font('Plus Jakarta Sans')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::STYLES_AFTER,
                fn (): string => '
                <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    /* Custom background to match landing page vibe */
                    .fi-body {
                        background-color: #f8fafc;
                        background-image: radial-gradient(at top left, rgba(250, 204, 21, 0.1) 0%, transparent 40%),
                                          radial-gradient(at bottom right, rgba(16, 185, 129, 0.1) 0%, transparent 40%);
                    }
                    /* Reduce sidebar menu spacing */
                    .fi-sidebar-nav-group-items {
                        gap: 0.125rem !important;
                    }
                    .fi-sidebar-nav-item .fi-sidebar-item-button {
                        padding-top: 0.375rem !important;
                        padding-bottom: 0.375rem !important;
                        min-height: 2rem !important;
                    }
                    ul.fi-sidebar-nav-groups {
                        gap: 0.5rem !important;
                    }
                    .fi-sidebar-nav-item {
                        margin-bottom: 0.125rem !important;
                    }
                    /* Make the login form card slightly styled */
                    .fi-simple-main .fi-modal-window {
                        box-shadow: 0 10px 40px -10px rgba(11, 61, 11, 0.1);
                        border: 1px solid rgba(11, 61, 11, 0.05);
                    }
                    .fi-logo {
                        font-family: \'Bebas Neue\', sans-serif;
                        font-size: 2.5rem;
                        letter-spacing: 1px;
                        color: #0b3d0b;
                    }
                </style>
                '
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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
                AdminOnly::class,
            ]);
    }
}
