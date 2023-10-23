<?php

namespace App\Filament\Resources\PacoteResource\Pages;

use App\Filament\Resources\PacoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPacotes extends ListRecords
{
    protected static string $resource = PacoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('F2 - Adicionar')
                ->keyBindings('f2'),
        ];
    }
}
