<?php

namespace App\Filament\Resources\HistoriaResource\RelationManagers;

use App\Filament\Resources\TarefaResource;
use App\Filament\Resources\TarefaResource\Pages\CreateTarefa;
use App\Filament\Resources\TarefaResource\Pages\EditTarefa;
use App\Filament\Resources\TarefaResource\Pages\ListTarefas;
use App\Filament\Resources\TarefaResource\Pages\ViewTarefa;
use App\Models\Tarefa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TarefaRelationManager extends RelationManager
{
    protected static string $relationship = 'Tarefa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo'),
                Tables\Columns\TextColumn::make('desenvolvedor.name'),
                Tables\Columns\TextColumn::make('data_inicio')->dateTime('d/m/Y'),
                Tables\Columns\TextColumn::make('status')->badge()
                ->color(fn (string $state): string => Tarefa::STATUS_COLORS[$state])
                    // ->formatStateUsing(fn (string $state): string => Tarefa::STATUS[$state]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
               
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => ListTarefas::route('/'),
            'create' => CreateTarefa::route('/create'),
          
            'edit' => EditTarefa::route('/{record}/edit'),

        ];
    }
}
