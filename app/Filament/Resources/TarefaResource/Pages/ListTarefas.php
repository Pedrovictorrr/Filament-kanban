<?php

namespace App\Filament\Resources\TarefaResource\Pages;

use App\Filament\Resources\TarefaResource;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab as ListRecordsTab;
use Illuminate\Database\Eloquent\Builder;

class ListTarefas extends ListRecords
{
    protected static string $resource = TarefaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Todos' => ListRecordsTab::make('Todos'),
            'A fazer' => ListRecordsTab::make('A fazer')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'A_Fazer')),
            'Fazendo' => ListRecordsTab::make('Fazendo')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Fazendo')),
            'Pausado' => ListRecordsTab::make('Pausado')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Pausado')),
            'Code Review' => ListRecordsTab::make('Code Review')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Code_Review')),
            'Feito' => ListRecordsTab::make('Feito')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Feito')),
            'Qualidade' => ListRecordsTab::make('Qualidade')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'Qualidade')),
        ];
    }
}
