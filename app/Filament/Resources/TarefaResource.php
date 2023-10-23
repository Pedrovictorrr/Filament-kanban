<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TarefaResource\Pages;
use App\Filament\Resources\TarefaResource\RelationManagers;
use App\Models\Tarefa;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use App\Actions\Star;
use App\Actions\ResetStars;
use App\Filament\Resources\TarefaResource\Widgets\TarefasStats;
use App\Models\Historia;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\Grid as ComponentsGrid;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Illuminate\Support\HtmlString;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;

class TarefaResource extends Resource
{

    protected static ?string $model = Tarefa::class;

    protected static ?string $navigationIcon = 'heroicon-o-window';

    protected static ?string $modelLabel = 'Tarefas';

    protected static ?string $navigationGroup = 'Backlog';

    // public static function getWidgets(): array
    // {
    //     return [
    //         TarefasStats::class,
    //     ];
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    Group::make()->schema([
                        Section::make('Tarefa')->schema([
                            Group::make()->schema([
                                TextInput::make('titulo')->label('Titulo'),
                                Select::make('historia_id')
                                    ->relationship(
                                        name: 'historia',
                                        titleAttribute: 'titulo',
                                    )
                                    ->native(false),
                            ])->columns(2),
                            Group::make()->schema([
                                Select::make('desenvolvedor_id')
                                    ->label('Desenvolvedor')
                                    ->native(false)
                                    ->relationship(
                                        name: 'desenvolvedor',
                                        titleAttribute: 'name',
                                    )
                                    ->suffixIcon('heroicon-m-command-line'),
                                Select::make('status')
                                    ->native(false)
                                    // ->options(Tarefa::STATUS)
                                    ->visibleOn('edit'),
                            ])->columns(2),
                            Group::make()->schema([
                                DatePicker::make('data_inicio')->native(false)->displayFormat('d/m/Y'),
                                DatePicker::make('data_fim')->native(false)->displayFormat('d/m/Y'),
                                TextInput::make('total_horas')
                                    ->numeric(),
                            ])->columns(3),
                            RichEditor::make('descricao')->label('História')
                                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Read it!')
                        ]),
                    ])->columnSpan([
                        'sm' => 3,
                        'xl' => 3,
                        '2xl' => 3,
                    ]),

                ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Desenvolvedor.name')
                    ->alignment(Alignment::Center),
                TextColumn::make('titulo')
                    ->alignment(Alignment::Center),


                TextColumn::make('Historia.titulo')
                    ->alignment(Alignment::Center)
                    ->label('História'),

                TextColumn::make('Historia.sistema.nome')
                    ->alignment(Alignment::Center)
                    ->label('Sistema'),

                TextColumn::make('dificuldade')
                    ->badge()->alignment(Alignment::Center),

                TextColumn::make('historia.prioridade')
                    ->label('Prioridade')
                    ->badge()->alignment(Alignment::Center)
                    ->color(fn (string $state): string => Historia::PRIORIDADE_COLORS[$state])
                    ->formatStateUsing(fn (string $state): string => Historia::PRIORIDADE[$state]),

                TextColumn::make('data_inicio')
                    ->alignment(Alignment::Center)
                    ->dateTime('d/m/Y'),

                TextColumn::make('status')
                    ->alignment(Alignment::Center)
                    ->badge(),
                // ->color(fn (string $state): string => Tarefa::STATUS_COLORS[$state])
                // ->formatStateUsing(fn (string $state): string => Tarefa::STATUS[$state]),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()->hidden(),
                    ActionsAction::make('Editar status')
                        ->form([
                            Select::make('status')
                                ->label('Status')
                                ->options(Tarefa::STATUS_DEV)
                                ->required()
                                ->native(false)
                                ->helperText(new HtmlString('Ao mudar o status para <strong>"Fazendo"</strong> a outra tarefa que estava com esse status passara para <strong>"Pausado"</strong>.')),
                            RichEditor::make('comentario')->required()->label('Motivo'),
                        ])
                        ->action(function (array $data, Tarefa $record): void {
                            $record->author()->associate($data['authorId']);
                            $record->save();
                        })
                        ->modalAlignment(Alignment::Center),
                ])
            ])
            ->bulkActions([])
            ->emptyStateActions([]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsGrid::make()->schema([
                    ComponentsGroup::make()->schema([
                        ComponentsSection::make('História')
                            ->collapsed()->schema([
                                TextEntry::make('descricao')->label('')->html(),
                            ]),
                        ComponentsSection::make('Histórico de horas')
                        ->collapsed()->schema([
                            RepeatableEntry::make('TarefaHoras')
                                ->schema([
                                    
                                    ImageEntry::make('User.avatar_url')
                                        ->label('')
                                        ->disk('local')
                                        ->height(60)
                                        ->circular(),
                                    TextEntry::make('User.name')->label('Usuário'),
                                    TextEntry::make('status'),
                                    TextEntry::make('horas_trabalhadas'),
                                    TextEntry::make('comentario')->html()->columnspanFull(),
                                ])
                                ->columns(4)
                        ])
                    ])->columnSpan(3),
                    ComponentsGroup::make()->schema([
                        ComponentsSection::make('Status')->schema([
                            TextEntry::make('status')
                                ->badge()->alignment(Alignment::Center),
                            // ->color(fn (string $state): string => Tarefa::STATUS_COLORS[$state]),
                            // ->formatStateUsing(fn (string $state): string => Tarefa::STATUS[$state]),
                            TextEntry::make('historia.prioridade')
                                ->label('Prioridade')
                                ->badge()->alignment(Alignment::Center)
                                ->color(fn (string $state): string => Historia::PRIORIDADE_COLORS[$state])
                                ->formatStateUsing(fn (string $state): string => Historia::PRIORIDADE[$state]),
                            TextEntry::make('data_inicio')
                                ->dateTime('d/m/Y'),
                            TextEntry::make('data_fim')
                                ->dateTime('d/m/Y'),
                            TextEntry::make('historia.user.name')
                                ->label('Revisores')
                                ->listWithLineBreaks()
                                ->bulleted(),

                            TextEntry::make('desenvolvedor.name')
                                ->label('Desenvolvedor'),

                        ])->columns(2),
                        ComponentsSection::make('Bitbucket info')->schema([]),

                    ])->columnSpan(2),
                ]) ->columns([
                    'sm' => 3,
                    'xl' => 5,
                    '2xl' => 5,
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTarefas::route('/'),
            'create' => Pages\CreateTarefa::route('/create'),
            'view' => Pages\ViewTarefa::route('/{record}'),
            // 'edit' => Pages\EditTarefa::route('/{record}/edit'),
        ];
    }
}
