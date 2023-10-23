<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoriaResource\Pages;
use App\Filament\Resources\HistoriaResource\RelationManagers\TarefaRelationManager;
use App\Filament\Resources\HistoriaResource\Widgets\HistoriaChart;
use App\Filament\Resources\HistoriaResource\Widgets\HistoriaViewChart;
use App\Models\Historia;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HistoriaResource extends Resource
{
    protected static ?string $model = Historia::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Histórias';

    protected static ?string $navigationGroup = 'Backlog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados Gerais')->schema([
                    TextInput::make('titulo')->label('Titulo'),
                    Select::make('tipo_historia')
                        ->relationship(name: 'TipoHistoria', titleAttribute: 'nome')
                        ->native(false),
                    Select::make('status')
                        ->options(Historia::STATUS)
                        ->native(false),
                    DatePicker::make('data_previsao_cliente')->native(false),
                    DatePicker::make('data_previsao_qa')->native(false),
                    TextInput::make('horas_previstas')
                        ->numeric(),
                    Select::make('prioridade')
                        ->options(Historia::PRIORIDADE)
                        ->native(false),
                    Select::make('projeto_id')
                        ->native(false)
                        ->preload()
                        ->relationship(
                            name: 'projeto',
                            titleAttribute: 'nome',
                        )->required(),
                    Select::make('user')
                        ->label('Analistas')
                        ->multiple()
                        ->native(false)
                        ->preload()
                        ->relationship(
                            name: 'user',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn (Builder $query) => $query->join('role_user', 'users.id', '=', 'role_user.user_id')
                                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                                ->where('roles.title', '=', 'Analista'),
                        )->required(),
                ])->columns(2),
                Section::make('História')->schema([
                    RichEditor::make('descricao')->label('')
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Read it!'),
                ]),
                Section::make('Anexos')->schema([
                    FileUpload::make('anexos')
                        ->label('')
                        ->multiple()
                        ->disk('local')
                        ->visibility('public')
                        ->directory('public/anexos-historia'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulo'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Historia::STATUS[$state]),
                TextColumn::make('TipoHistoria.nome'),
                TextColumn::make('prioridade')
                    ->badge()
                    ->color(fn (string $state): string => Historia::PRIORIDADE_COLORS[$state])
                    ->formatStateUsing(fn (string $state): string => Historia::PRIORIDADE[$state]),
                TextColumn::make('Projeto.nome')
                    ->badge(),
                TextColumn::make('data_previsao_cliente')->label('Data de entrega')->dateTime('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([]);
    }

    public static function getRelations(): array
    {
        return [
            TarefaRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            HistoriaChart::class,
            HistoriaViewChart::class,
        ];
    }

    public static function getPages(): array
    {
        return [

            'index' => Pages\ListHistorias::route('/'),
            'create' => Pages\CreateHistoria::route('/create'),
            'view' => Pages\ViewHistoria::route('/{record}'),
            'edit' => Pages\EditHistoria::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(
                [
                    Grid::make()->schema([
                        Group::make()->schema([
                            ComponentsSection::make()->schema([
                                TextEntry::make('titulo'),
                                TextEntry::make('status')->badge()
                                    ->formatStateUsing(fn (string $state): string => Historia::STATUS[$state]),
                                TextEntry::make('tipo_historia'),
                                TextEntry::make('Projeto.nome')->badge(),
                                TextEntry::make('prioridade')->badge()
                                    ->formatStateUsing(fn (string $state): string => Historia::PRIORIDADE[$state]),
                                TextEntry::make('data_previsao_cliente')
                                    ->label('Previsão para entrega')
                                    ->dateTime('d/m/Y'),
                                TextEntry::make('data_previsao_qa')
                                    ->label('Data de inicio do qualidade')
                                    ->dateTime('d/m/Y'),
                                TextEntry::make('horas_previstas')
                                    ->label('Data de entrega para qualidade'),

                            ])->columns(2),
                        ]),
                        Group::make()->schema([
                            Tabs::make('Label')
                                ->tabs([
                                    Tabs\Tab::make('Atividade')
                                        ->schema([
                                            TextEntry::make('status')->view('infolists.components.historia-atividade'),
                                        ]),
                                    Tabs\Tab::make('Equipe')
                                        ->schema([
                                            RepeatableEntry::make('user')->label('')
                                                ->schema([
                                                    ImageEntry::make('foto')
                                                        ->disk('local')
                                                        ->label('')
                                                        ->height(40)
                                                        ->square()
                                                        ->columnSpan(1),
                                                    TextEntry::make('name')->label('')->columnSpan(2),
                                                    TextEntry::make('roles.0.title')
                                                        ->badge()
                                                        ->label('')
                                                        ->columnSpan(2),
                                                ])->columns(5)
                                                ->contained(false),

                                        ]),
                                    Tabs\Tab::make('Tempo')
                                        ->schema([
                                            TextEntry::make('teste')->view('infolists.components.historia-tempo'),
                                        ]),
                                ]),
                        ]),
                    ])->columns(2),

                    ComponentsSection::make('História')->schema([
                        TextEntry::make('descricao')->label('')->html(),
                    ])->collapsed(true),
                ]
            );
    }
}
