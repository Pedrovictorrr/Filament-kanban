<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PacoteResource\Pages;
use App\Filament\Resources\PacoteResource\RelationManagers\HistoriaRelationManager;
use App\Models\Historia;
use App\Models\Pacote;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PacoteResource extends Resource
{
    protected static ?string $model = Pacote::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Cadastro';

    protected static ?string $modelLabel = 'Pacotes';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('horas_previstas')
                        ->required()
                        ->numeric(),
                ])->columns(2),
                Section::make()->schema([
                    Repeater::make('PacoteHistoria')

                        ->collapsible()
                        ->reorderableWithButtons()
                        ->relationship()
                        ->schema([
                            Select::make('historia_id')
                            ->relationship('historia', 'titulo')
                                ->native(false)
                                ->required()
                                ->suffixAction(
                                    Action::make('EditarHistoria')
                                        ->icon('heroicon-m-clipboard')
                                        ->fillForm(
                                            function ($state): array {

                                                $historia = Historia::where('id', $state)->first();
                                                $historiaUsuarios = $historia->user;
                                                $analista = [];

                                                foreach ($historiaUsuarios as $usuario) {
                                                    // Suponha que 'id' e 'nome' sejam propriedades do objeto $usuario
                                                    $id = $usuario->id;
                                                    $nome = $usuario->nome;

                                                    // Adiciona os dados ao array analista
                                                    $analista[] = ['id' => $id, 'nome' => $nome];
                                                }
                                                $content = [
                                                    'titulo' => $historia->titulo,
                                                    'tipo_historia' =>  $historia->tipo_historia,
                                                    'status' =>  $historia->status,
                                                    'data_previsao_cliente' =>  $historia->data_previsao_cliente,
                                                    'data_previsao_qa' =>  $historia->data_previsao_qa,
                                                    'horas_previstas' =>  $historia->horas_previstas,
                                                    'prioridade' =>  $historia->prioridade,
                                                    'projeto_id' =>  $historia->projeto_id,
                                                    'a' => $analista,
                                                    'descricao' =>  $historia->descricao,
                                                    'anexos' =>  $historia->anexos,
                                                ];
                                                return $content;
                                            }


                                        )
                                        ->form([
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
                                        ])
                                        ->action(function (array $data,$state): void {
                                            
                                            $historia = Historia::where('id', $state)->first();
                                            $historia->update($data);

                                              Notification::make()
                                            ->title('Atualizado com sucesso')
                                            ->success()
                                            ->color('success')
                                            ->send();
                                        })
                                        ->slideOver()
                                ),
                        ])   
                    
                    // ...

                ])->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nome', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('horas_previstas'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListPacotes::route('/'),
            'create' => Pages\CreatePacote::route('/create'),
            'edit' => Pages\EditPacote::route('/{record}/edit'),
        ];
    }
}
