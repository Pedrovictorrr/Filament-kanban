<?php

namespace App\Filament\Resources\ProjetoResource\RelationManagers;

use App\Models\Historia;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoriaRelationManager extends RelationManager
{
    protected static string $relationship = 'historia';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titulo')
            ->columns([
                TextColumn::make('titulo'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aberto' => 'info',
                        'fechado' => 'gray',
                        'andamento' => 'warning',
                        'concluido' => 'success',
                        'cancelado' => 'danger',
                        'espera' => 'warning',
                        'pendente' => 'warning',
                        'resolvido' => 'purple',
                        'reaberto' => 'success',
                        'em_espera_cliente' => 'info'
                    })
                    ->formatStateUsing(fn (string $state): string => Historia::STATUS[$state]),
                TextColumn::make('tipo')
                    ->formatStateUsing(fn (string $state): string => Historia::TIPO[$state]),
                TextColumn::make('prioridade')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'alta_prioridade' => 'danger',
                    'media_prioridade'  => 'warning',
                    'pequena_prioridade'  => 'info',
                    'normal'  => 'success'
                })
                    ->formatStateUsing(fn (string $state): string => Historia::PRIORIDADE[$state]),
                TextColumn::make('dificuldade')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'muito_facil' => 'gray',
                    'facil'  => 'info',
                    'medio'  => 'warning',
                    'dificil'  => 'danger',
                    'muito_dificil' => 'primary'
                })
                    ->formatStateUsing(fn (string $state): string => Historia::DIFICULDADE[$state]),
                TextColumn::make('data_fim')->label('Data de entrega'),
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
}
