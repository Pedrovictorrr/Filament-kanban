<?php

namespace App\Filament\Resources\HistoriaResource\Pages;

use App\Filament\Resources\HistoriaResource;
use App\Models\Tarefa;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewHistoria extends ViewRecord
{
    protected static string $resource = HistoriaResource::class;


    protected static string $view = 'filament.resources.historias.pages.view-historia';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
           
        ];
    }
}
