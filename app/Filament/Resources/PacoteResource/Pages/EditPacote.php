<?php

namespace App\Filament\Resources\PacoteResource\Pages;

use App\Filament\Resources\PacoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditPacote extends EditRecord
{
    protected static string $resource = PacoteResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

 
    

    public function getTitle(): string | Htmlable
{
    return $this->record->nome;;
}
    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            Actions\DeleteAction::make(),
        ];
    }
}
