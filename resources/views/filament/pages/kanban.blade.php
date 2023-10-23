<x-filament-panels::page>
    @push('scripts')
        <script>
            function dragover(evt) {
                evt.preventDefault();
                evt.dataTransfer.dropEffect = "move";

            }

            function dragLeave(evt) {} // available if required
            function dragEnd(evt) {} // available if required
            function dragstart(evt) {
                evt.dataTransfer.setData("text/plain", evt.target.id);
                evt.dataTransfer.effectAllowed = "move";
            }

            function drop(evt) {
                evt.preventDefault();
                var id_tarefa = evt.dataTransfer.getData("text");
                var targetColumnId = evt.target.id;
                var status = evt.target.closest('.scrum-board-column').id;
                evt.target.closest('.scrum-board-column').appendChild(document.getElementById(id_tarefa));
                @this.atualizarPosicaoElemento(id_tarefa, status)
                    .then(function(response) {
                        // Lógica para lidar com a resposta, se necessário
                        console.log("Resposta recebida:", response);
                    })
                    .catch(function(error) {
                        // Lógica para lidar com erros, se necessário
                        console.error("Erro ao atualizar posição do elemento:", error);
                    });
            }
        </script>
    @endpush
    <style>
        .fi-fieldset {
            padding: 2px !important;
            background-color: rgba(45, 45, 45, 0.053)
        }

        .fi-section {
            padding: 2px !important;
            width: 300px !important;
        }
    </style>
    <div class="mt-1">


        <div class="scrum-board-container">
            <div class="flex-kanban overflow-x-auto">
                <div class="scrum-board">
                    <x-filament::fieldset>
                        <x-slot name="label">
                            <div class="flex">
                                <x-filament::badge color='purple' class="ml-3" style="margin-right: 2px!important">
                                    A Fazer
                                </x-filament::badge>
                                <x-filament::badge color='purple' class="ml-3">
                                   {{$afazer->count()}}
                                </x-filament::badge>
                            </div>
                        </x-slot>
                        <div class="scrum-board-column" ondrop="drop(event)" ondragover="dragover(event)" id="A_Fazer">
                            @foreach ($afazer as $tarefa)
                                @include('filament.pages.kanban.modal', ['tarefas' => $tarefa])
                            @endforeach
                            @if ($afazer->count() < 1)
                            <div class="flex justify-center content-center" style="margin-top: 65px">
                                 {{$this->CreateAction("afazer")}}
                            </div>
                        @endif
                        </div>
                    </x-filament::fieldset>
                </div>
                <div class="scrum-board in-progress">
                    <x-filament::fieldset>
                        <x-slot name="label">
                            <x-filament::badge color='info' class="ml-3">
                                Fazendo
                            </x-filament::badge>
                        </x-slot>
                        <div class="scrum-board-column" ondrop="drop(event)" ondragover="dragover(event)"
                            id="Fazendo">
                            @foreach ($fazendo as $tarefa)
                                @include('filament.pages.kanban.modal', ['tarefas' => $tarefa])
                            @endforeach
                            @if ($fazendo->count() < 1)
                            <div class="flex justify-center content-center" style="margin-top: 65px">
                                 {{$this->CreateAction("fazendo")}}
                            </div>
                        @endif

                        </div>
                    </x-filament::fieldset>
                </div>
                <div class="scrum-board  done">
                    <x-filament::fieldset>
                        <x-slot name="label">
                            <x-filament::badge color='danger' class="ml-3">
                                Pausado
                            </x-filament::badge>
                        </x-slot>
                        <div class="scrum-board-column bg-primary" ondrop="drop(event)" ondragover="dragover(event)"
                            id="Pausado">
                            @foreach ($pausado as $tarefa)
                                @include('filament.pages.kanban.modal', ['tarefas' => $tarefa])
                            @endforeach
                            @if ($pausado->count() < 1)
                            <div class="flex justify-center content-center" style="margin-top: 65px">
                                 {{$this->CreateAction("pausado")}}
                            </div>
                        @endif
                        </div>
                    </x-filament::fieldset>
                </div>
                <div class="scrum-board done">
                    <x-filament::fieldset>
                        <x-slot name="label">
                            <x-filament::badge color='warning' class="ml-3">
                                Code Review
                            </x-filament::badge>
                        </x-slot>
                        <div class="scrum-board-column" ondrop="drop(event)" ondragover="dragover(event)"
                            id="Code_Review">
                            @foreach ($codereview as $tarefa)
                                @include('filament.pages.kanban.modal', ['tarefas' => $tarefa])
                            @endforeach
                            @if ($codereview->count() < 1)
                            <div class="flex justify-center content-center" style="margin-top: 65px">
                                 {{$this->CreateAction("codereview")}}
                            </div>
                        @endif
                        </div>
                    </x-filament::fieldset>
                </div>
                <div class="scrum-board done">
                    <x-filament::fieldset>
                        <x-slot name="label">
                            <x-filament::badge color='success' class="ml-3">
                                Feito / Qualidade
                            </x-filament::badge>
                        </x-slot>
                        <div class="scrum-board-column" ondrop="drop(event)" ondragover="dragover(event)"
                            id="Feito">
                            @foreach ($feito as $tarefa)
                                @include('filament.pages.kanban.modal', ['tarefas' => $tarefa])
                            @endforeach
                            @if ($feito->count() < 1)
                                <div class="flex justify-center content-center" style="margin-top: 65px">
                                  {{$this->CreateAction("feito")}}
                                </div>
                            @endif
                        </div>
                    </x-filament::fieldset>
                </div>
            </div>
        </div>
    </div>
    <style>
        .scrum-board-container {
            font-family: Arial;

            -webkit-user-select: none;
        }

        .board-title {
            background-color: #f1f1f1;
            padding: 5px 20px;
        }

        .flex-kanban {
            display: flex;
            flex-direction: row;
        }

        .scrum-board {
            flex: 1;
            padding: 10px;
        }

        .scrum-board:first-child {
            flex: 1;
            padding: 10px;
        }

        .scrum-task {
            position: relative;
            display: block;
            width: 300px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: all-scroll;
        }

        .scrum-task.over {
            border-top: 2px solid red;
        }



        .scrum-task-description:not(:empty) {
            margin-top: 10px;
        }

        .scrum-task-date:not(:empty) {
            margin-top: 10px;
            display: inline-block;
        }

        .scrum-task-assignee:not(:empty) {
            text-align: right;
        }

        .scrum-task-assignee>.assignee:not(:empty) {
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            height: 28px;
            line-height: 28px;
            width: 28px;
            background-color: #dfe3e6;
            border-radius: 25em;
            color: #17394d;
            display: inline-block;
            -webkit-user-select: none;
        }

        .scrum-board-column {
            width: 320px;
            min-height: 200px;
            padding: 10px;
            height: 100%;
        }
    </style>
</x-filament-panels::page>
