<?php

namespace App\Filament\Resources\HistoriaResource\Pages;

use App\Filament\Resources\HistoriaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHistoria extends EditRecord
{
    protected static string $resource = HistoriaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            DeleteAction::make(),
        ];
    }
}
