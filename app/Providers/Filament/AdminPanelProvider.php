<?php

namespace App\Providers\Filament;

use App\Filament\AvatarProviders\AvatarProvider;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\ResetPassword;
use Awcodes\FilamentGravatar\GravatarPlugin;
use Awcodes\FilamentGravatar\GravatarProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->favicon(asset('images/favicon.png'))
            ->path('')
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->sidebarCollapsibleOnDesktop()
            ->passwordReset(ResetPassword::class)
            ->plugins([
                GravatarPlugin::make(),
            ])
            ->maxContentWidth('full')
            ->colors([
                'primary' => Color::Blue,
                'danger' => Color::Red,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Amber,
                'slate' => Color::Slate,
                'zinc' => Color::Zinc,
                'neutral' => Color::Neutral,
                'stone' => Color::Stone,
                'red' => Color::Red,
                'orange' => Color::Orange,
                'amber' => Color::Amber,
                'yellow' => Color::Yellow,
                'lime' => Color::Lime,
                'green' => Color::Green,
                'emerald' => Color::Emerald,
                'teal' => Color::Teal,
                'cyan' => Color::Cyan,
                'sky' => Color::Sky,
                'blue' => Color::Blue,
                'indigo' => Color::Indigo,
                'violet' => Color::Violet,
                'purple' => Color::Purple,
                'fuchsia' => Color::Fuchsia,
                'pink' => Color::Pink,
                'rose' => Color::Rose,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ->databaseNotifications()
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->navigationGroups([
            //     'Chamados',
            //     'Cadastro',
            //     'Versionamento de código',
            //     'Configurações',
            //     'Usuários'
            // ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Backlog')
                    ->collapsed(true),
                    NavigationGroup::make()
                    ->label('Minhas Tarefas')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('Cadastro')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('Versionamento de código')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('W2O')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('Usuários')
                    ->collapsed(true),
            ])
            // ->collapsibleNavigationGroups(false)
            ->authGuard('web')
            ->authPasswordBroker('users')
            ->userMenuItems([
                MenuItem::make()
                    ->label('Release')
                    ->url('/release-public')
                    ->icon('heroicon-o-rocket-launch'),
                // ...
            ]);
    }
}
