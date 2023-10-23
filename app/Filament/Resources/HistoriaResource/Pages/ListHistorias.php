<?php

namespace App\Filament\Resources\HistoriaResource\Pages;

use App\Filament\Resources\HistoriaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHistorias extends ListRecords
{
    protected static string $resource = HistoriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('F2 - Adicionar')
                ->keyBindings('f2'),
        ];
    }

    //    protected function getHeaderWidgets(): array
    //    {
    //        return HistoriaResource::getWidgets();
    //    }
}
