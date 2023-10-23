<?php

namespace App\Filament\Pages;

use App\Models\Historia;
use App\Models\Tarefa;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid as ComponentsGrid;
use Filament\Forms\Components\Group as ComponentsGroup;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;

class Kanban extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $modelLabel = 'Kanban Dev';

    protected static ?string $navigationGroup = 'Minhas Tarefas';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Adicionar')->form([

                ComponentsGroup::make()->schema([
                    TextInput::make('titulo')->label('Titulo'),
                    Select::make('historia_id')

                        ->native(false),
                ])->columns(2),
                ComponentsGroup::make()->schema([
                    Select::make('desenvolvedor_id')
                        ->label('Desenvolvedor')
                        ->native(false)
                        ->suffixIcon('heroicon-m-command-line'),
                    Select::make('status')
                        ->native(false)
                        // ->options(Tarefa::STATUS)
                        ->visibleOn('edit'),
                ])->columns(2),
                ComponentsGroup::make()->schema([
                    DatePicker::make('data_inicio')->native(false)->displayFormat('d/m/Y'),
                    DatePicker::make('data_fim')->native(false)->displayFormat('d/m/Y'),
                    TextInput::make('total_horas')
                        ->numeric(),
                ])->columns(3),
                RichEditor::make('descricao')->label('História')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Read it!')

            ])
                ->action(function (array $data, Tarefa $record): void {
                }),
        ];
    }


    public function CreateAction($status)
    {   
        return 
            Action::make('Adicionar')  ->icon('heroicon-m-plus')
            ->iconButton()->form([
                ComponentsGroup::make()->schema([
                    TextInput::make('titulo')->label('Titulo'),
                    Select::make('historia_id')

                        ->native(false),
                ])->columns(2),
                ComponentsGroup::make()->schema([
                    Select::make('desenvolvedor_id')
                        ->label('Desenvolvedor')
                        ->native(false)
                        ->suffixIcon('heroicon-m-command-line'),
                    Select::make('status')
                        ->native(false)
                        // ->options(Tarefa::STATUS)
                        ->visibleOn('edit'),
                ])->columns(2),
                ComponentsGroup::make()->schema([
                    DatePicker::make('data_inicio')->native(false)->displayFormat('d/m/Y'),
                    DatePicker::make('data_fim')->native(false)->displayFormat('d/m/Y'),
                    TextInput::make('total_horas')
                        ->numeric(),
                ])->columns(3),
                RichEditor::make('descricao')->label('História')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Read it!')

            ])
                ->action(function (array $data, Tarefa $record): void {
                });
        
    }
    public function editAction(): Action
    {
        return Action::make('Editar')
            ->link()
            ->form([
                // ...
            ])
            // ...
            ->action(function (array $arguments) {

                // ...

                $this->replaceMountedAction('publish', $arguments);
            });
    }
    public function InputComentario():Component
    {
        return  RichEditor::make('Comentario')->label('Escrever comentario')
            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Read it!');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->InputComentario(),
            ])
            ->statePath('data');
    }

    public function DeleteAction(): Action
    {
        return Action::make('Delete')
            ->form([
                // ...
            ])
            // ...
            ->action(function (array $arguments) {

                // ...

                $this->replaceMountedAction('publish', $arguments);
            });
    }
    protected static string $view = 'filament.pages.kanban';

    protected $listeners = ['atualizarPosicaoElemento'];

    public $post;
    public $tarefas;

    public $afazer, $fazendo, $pausado, $codereview, $feito;

    public function mount()
    {
        $this->tarefas = Tarefa::get();
        $this->post = 'teste';
        $this->afazer = Tarefa::where('status', 'A_Fazer')->get();
        $this->fazendo = Tarefa::where('status', 'Fazendo')->get();
        $this->pausado = Tarefa::where('status', 'Pausado')->get();
        $this->codereview = Tarefa::where('status', 'Code_Review')->get();
        $this->feito = Tarefa::where('status', 'Feito')->get();
    }

    public function atualizarPosicaoElemento($id_tarefa, $status)
    {
        Tarefa::where('id', $id_tarefa)->update(['status' => $status]);
        $this->mount();
        return true;
    }
}
