<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjetoResource\Pages;
use App\Filament\Resources\ProjetoResource\RelationManagers\HistoriaRelationManager;
use App\Models\Projeto;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjetoResource extends Resource
{
    protected static ?string $model = Projeto::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $modelLabel = 'Projetos';

    protected static ?string $navigationGroup = 'Cadastro';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Grid::make()->schema([
                    Group::make()->schema([
                        Section::make('Dados')->schema([
                            FileUpload::make('avatar_url')->disk('local')->columnspanFull()->directory('public/projetos'),
                            TextInput::make('nome')
                                ->label('Nome do projeto')
                                ->required()
                                ->maxLength(255),
                            Select::make('cliente_id')
                                ->label('Cliente')
                                ->native(false)
                                ->preload()
                                ->relationship(
                                    name: 'cliente',
                                    titleAttribute: 'nome',
                                ),
                        ])->columns(2),
                    ])->columnSpan([
                        'sm' => 4,
                        'xl' => 4,
                        '2xl' => 4,
                    ]),

                ])->columns(4),

            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')->disk('local'),
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('cliente.nome')
                ->label('Cliente')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [
            HistoriaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjetos::route('/'),
            'create' => Pages\CreateProjeto::route('/create'),
            'edit' => Pages\EditProjeto::route('/{record}/edit'),
        ];
    }
}
