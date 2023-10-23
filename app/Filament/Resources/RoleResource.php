<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Funções';

    protected static ?string $navigationGroup = 'W2O';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->disabled(fn (Get $get) => $get('title') === 'Super' || $get('title') === 'Inativo'),
                ]),
                Select::make('Permissões')
                    ->native(false)
                    ->multiple()
                    ->preload()
                    ->relationship(name: 'permissions', titleAttribute: 'title',
                        modifyQueryUsing: fn (Builder $query) => $query->whereIn('id', Auth()->user()->roles->flatMap->permissions->pluck('id'))
                    )
                    ->hidden(fn (Get $get) => $get('title') === 'Inativo')
                    ->disabled(fn (Get $get) => $get('title') === 'Super'),

                Select::make('users')
                    ->native(false)
                    ->multiple()
                    ->preload()
                    ->relationship(
                        name: 'users',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => Auth()->user()->hasRole('Super') ? null : $query->whereDoesntHave('roles', function ($query) {
                            $query->where('title', '=', 'Super');
                        })
                    )
                    ->disabled(fn (Get $get) => $get('title') === 'Super'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Role::where('title', '!=', 'Super'))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('users_count')->counts('users')->label('Total de usuários'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRoles::route('/'),
        ];
    }
}
