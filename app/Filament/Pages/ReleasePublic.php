<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ReleasesResource;
use App\Models\Releases;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class ReleasePublic extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.release-public';

    protected static bool $shouldRegisterNavigation = false;

    public $model;

    protected static ?string $title = 'Releases';



    public function mount()
    {
        $this->model = Releases::get();
    }

    public function getFooter(): ?View
    {
        return view('filament.pages.footer');
    }

}
