<?php

namespace App\Filament\Resources\TarefaResource\Pages;

use App\Filament\Resources\TarefaResource;
use App\Models\Tarefa;
use App\Models\TarefaHoras;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\HtmlString;

class ViewTarefa extends ViewRecord
{
    protected static string $resource = TarefaResource::class;

    protected function getHeaderActions(): array
    {

        return [
            EditAction::make('Editar tarefa')
                ->label('Editar Tarefa')
                ->form([
                    TextInput::make('titulo')->placeholder(Tarefa::where('id', $this->record->id)->get()->value('titulo')),
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
                    DatePicker::make('data_inicio')->native(false)->displayFormat('d/m/Y'),
                    DatePicker::make('data_fim')->native(false)->displayFormat('d/m/Y'),
                    TextInput::make('total_horas')
                        ->numeric(),
                    RichEditor::make('descricao')->label('História')
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Read it!')
                ])
                ->slideOver(),
            EditAction::make('Editar status')
                ->label('Editar Status')
                ->form([
                    Select::make('status')
                        ->label('Status')
                        ->options(function () {
                            $statusAtual = Tarefa::where('id', $this->record->id)->get()->value('status');
                            switch ($statusAtual) {
                                case 'A_Fazer':
                                    $novoStatuses = ['Fazendo' => 'Fazendo'];
                                    break;
                                case 'Code_Review':
                                    // Não faz nada, não adiciona nenhum status ao array
                                    break;
                                case 'Feito':
                                    $novoStatuses = ['Qualidade' => 'Qualidade'];;
                                    break;
                                case 'Fazendo':

                                    $novoStatuses = [
                                        'Feito' => 'Feito',
                                        'Fazendo' => 'Fazendo',
                                        'Pausado' => 'Pausado'
                                    ];

                                    break;
                                case 'Pausado':

                                    $novoStatuses = [
                                        'Fazendo' => 'Fazendo',
                                        'Feito' => 'Feito'
                                    ];

                                    break;
                                default:
                                    // Retorna um status padrão ou lança uma exceção, dependendo dos requisitos do seu aplicativo
                                    break;
                            }

                            return $novoStatuses;
                        })
                        ->getOptionLabelUsing(fn ($value): ?string => Tarefa::STATUS_DEV[$value])
                        ->required()
                        ->native(false)
                        ->default($this->record->status)
                        ->helperText(new HtmlString('Ao mudar o status para <strong>"Fazendo"</strong> a outra tarefa que estava com esse status passara para <strong>"Pausado"</strong>.')),
                    Select::make('horas_trabalhadas')
                        ->required()
                        ->native(false)
                        ->options([
                            '00:30' => '00:30',
                            '01:00' => '01:00',
                            '01:30' => '01:30',
                            '02:00' => '02:00',
                            '02:30' => '02:30',
                            '03:00' => '03:00',
                            '03:30' => '03:30',
                            '04:00' => '04:00',
                            '04:30' => '04:30',
                            '05:00' => '05:00',
                            '05:30' => '05:30',
                            '06:00' => '06:00',
                            '06:30' => '06:30',
                            '07:00' => '07:00',
                            '07:30' => '07:30',
                            '08:00' => '08:00',
                            '08:30' => '08:30',
                            '09:00' => '09:00',
                            '09:30' => '09:30',
                            '10:00' => '10:00',
                            '10:30' => '10:30',
                            '11:00' => '11:00',
                            '11:30' => '11:30',
                            '12:00' => '12:00'
                        ]),
                    RichEditor::make('comentario')->required()->label('Comentario'),
                ])->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    $data['tarefa_id'] = $this->record->id;
                    TarefaHoras::create($data);
                    return $data;
                })
                ->modalAlignment(Alignment::Center)
        ];
    }
}
