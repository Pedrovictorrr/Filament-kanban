<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class footer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.footer';

    protected static bool $shouldRegisterNavigation = false;


}
