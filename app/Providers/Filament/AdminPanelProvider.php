<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
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
            ->id('admin')
            ->path('cms')
            ->login()
            ->colors(['primary' => Color::hex('#2563EB')])
            ->brandName('Emmanuel CMS')
            ->brandLogo(null)
            ->favicon(null)
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->pages([Pages\Dashboard::class])
            ->widgets([Widgets\AccountWidget::class])
            ->navigationItems([
                NavigationItem::make('Home')
                    ->url('/cms/page-management?section=home')
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.page-management') && request()->query('section', 'home') === 'home'),
                NavigationItem::make('Career Center')
                    ->url('/cms/page-management?section=career-center')
                    ->icon('heroicon-o-briefcase')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'career-center'),
                NavigationItem::make('Resume Center')
                    ->url('/cms/page-management?section=resume-center')
                    ->icon('heroicon-o-document-text')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'resume-center'),
                NavigationItem::make('Expertise')
                    ->url('/cms/page-management?section=expertise')
                    ->icon('heroicon-o-academic-cap')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'expertise'),
                NavigationItem::make('Portfolio')
                    ->url('/cms/page-management?section=portfolio')
                    ->icon('heroicon-o-rectangle-stack')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'portfolio'),
                NavigationItem::make('Journey')
                    ->url('/cms/page-management?section=journey')
                    ->icon('heroicon-o-map')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'journey'),
                NavigationItem::make('Connect')
                    ->url('/cms/page-management?section=connect')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'connect'),
                NavigationItem::make('Hire Me')
                    ->url('/cms/page-management?section=hire-me')
                    ->icon('heroicon-o-hand-raised')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'hire-me'),
                NavigationItem::make('Brand Center')
                    ->url('/cms/page-management?section=brand-center')
                    ->icon('heroicon-o-swatch')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'brand-center'),
                NavigationItem::make('Media Library')
                    ->url('/cms/page-management?section=media-library')
                    ->icon('heroicon-o-photo')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'media-library'),
                NavigationItem::make('Preview Center')
                    ->url('/cms/page-management?section=preview-center')
                    ->icon('heroicon-o-eye')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'preview-center'),
                NavigationItem::make('Publish Center')
                    ->url('/cms/page-management?section=publish-center')
                    ->icon('heroicon-o-paper-airplane')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'publish-center'),
                NavigationItem::make('Analytics')
                    ->url('/cms/page-management?section=analytics')
                    ->icon('heroicon-o-chart-bar')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'analytics'),
                NavigationItem::make('Settings')
                    ->url('/cms/page-management?section=settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->isActiveWhen(fn(): bool => request()->query('section') === 'settings'),
            ])
            ->renderHook(PanelsRenderHook::PAGE_START, fn() => view('filament.admin.back-link'))
            ->renderHook(PanelsRenderHook::HEAD_END, fn() => view('filament.admin.panel-styles'))
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
            ->authMiddleware([Authenticate::class]);
    }
}
