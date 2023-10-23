<?php

namespace App\Filament\Resources\ReleasesResource\Pages;

use App\Filament\Resources\ReleasesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;

class ManageReleases extends ManageRecords
{
    protected static string $resource = ReleasesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getFooter(): ?View
    {
        return view('filament.pages.footer');
    }
}
