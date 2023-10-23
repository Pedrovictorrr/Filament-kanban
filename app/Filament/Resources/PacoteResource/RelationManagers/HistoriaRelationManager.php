<?php

namespace App\Filament\Resources\PacoteResource\RelationManagers;

use App\Filament\Resources\HistoriaResource\Pages\EditHistoria;
use App\Filament\Resources\HistoriaResource\Pages\ViewHistoria;
use App\Models\Historia;
use App\Models\Pacote;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class HistoriaRelationManager extends RelationManager
{
    protected static string $relationship = 'Historia';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pacote_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo'),
                Tables\Columns\TextColumn::make('prioridade')
                    ->color(fn (string $state): string => Historia::PRIORIDADE_COLORS[$state])
                    ->formatStateUsing(fn (string $state): string => Historia::PRIORIDADE[$state])
                    ->badge(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->formatStateUsing(fn (string $state): string => Historia::STATUS[$state]),
                Tables\Columns\TextColumn::make('data_previsao_cliente')->dateTime('d/m/Y'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Vincular nova história')->color('primary')->form([
                    Select::make('historia_id')
                        ->label('Historia')
                        ->options(Historia::get()->pluck('titulo', 'id'))
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
                                ->action(function (array $data, $state): void {

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
                ])  ->action(function (array $data): void {
                    $pacoteId = $this->ownerRecord->id;
                    $historiasIds = $data['historia_id']; // Supondo que $data['historia'] seja um array de ids de histórias
                    
                    $pacote = Pacote::find($pacoteId);
                    $pacote->Historia()->sync($historiasIds);
                    
                

                    Notification::make()
                        ->title('Atualizado com sucesso')
                        ->success()
                        ->color('success')
                        ->send();
                }),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Desvincular')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Historia $user) {
                            $user->Pacote()->detach();
                            $user->save();
                        }),
                ]),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([]);
    }
}
