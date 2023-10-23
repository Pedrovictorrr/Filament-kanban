              {{-- Card kanbam --}}
              <div class="scrum-task overflow" draggable="true" ondragstart="dragstart(event)" id="{{ $tarefa->id }}">
                  <x-filament::modal slide-over width="6xl">
                      <x-slot name="heading">
                          <div class="flex">
                              <x-filament::icon-button icon="heroicon-m-rocket-launch" color="primary" label="New label" />
                              <div class="p-1">
                                  {{ $tarefa->Historia->titulo }}
                              </div>
                          </div>
                      </x-slot>
                      <x-slot name="trigger">
                          <button>
                            @include('filament.pages.kanban.card', ['tarefa' => $tarefa])
                          </button>
                      </x-slot>
                      <x-slot name="description">
                          # {{ $tarefa->titulo }}
                          <div class="flex mt-2">
                              <x-filament::badge color='success' class="ml-3" style="margin-right: 5px">
                                  {{ $tarefa->status }}
                              </x-filament::badge>
                              @if ($tarefa->Historia->prioridade == 'normal')
                                  <x-filament::badge color='primary' class="ml-3">
                                      Normal
                                  </x-filament::badge>
                              @else
                                  <x-filament::badge color='danger' class="ml-3">
                                      Urgente
                                  </x-filament::badge>
                              @endif
                              <x-filament::badge color='warning' class="ml-3" style="margin-left: 5px!important">
                                        {{ $tarefa->Historia->Projeto->nome }}
                                      </x-filament::badge>
                          </div>
                      </x-slot>
                      <hr>
                      <div class="flex">
                          <div class="flex-1">
                              <div class="flex justify-between">
                                  <div class="flex">
                                      <x-filament::avatar class="rounded-full" size="w-9 h-9"
                                          src="{{  str_replace('public/', '/storage/', $tarefa->Desenvolvedor->avatar_url) }}"
                                          alt="Dan Harrin" />
                                      <div class="flex p-1">
                                          <div class="text-sm">
                                              <strong>{{ $tarefa->Desenvolvedor->name }}</strong>
                                          </div>
                                          <div class="text-sm"
                                              style="color:rgb(141, 141, 141); margin-left: 5px!important;">
                                              # {{ $tarefa->created_at }}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="" style="margin-right: 5px">
                                      {{ $this->editAction }}
                                  </div>
                              </div>
                              <div class="p-2 mt-3 text-sm">
                                  {!! $tarefa->descricao !!}
                              </div>
                              <hr class="mt-2">
                              <div>
                                  <div class="p-2 text-lg">
                                      Ações:
                                  </div>
                                  <ol class="relative border-l border-gray-200 dark:border-gray-700">
                                    @include('filament.pages.kanban.coment', ['tarefa' => $tarefa])
                                  </ol>
                                  <div>
                                      {{ $this->form }}
                                  </div>
                              </div>
                          </div>
                          <div class="flex-auto " style="width: 400px">
                              <div class="p-2">
                                  <div class="flex justify-between mt-1">
                                      <div>
                                          chave
                                      </div>
                                      <div>
                                          valor
                                      </div>
                                  </div>

                                  <div class="flex justify-between mt-1">
                                      <div>
                                          chave
                                      </div>
                                      <div>
                                          valor
                                      </div>
                                  </div>

                                  <div class="flex justify-between mt-1">
                                      <div>
                                          chave
                                      </div>
                                      <div>
                                          valor
                                      </div>
                                  </div>

                                  <div class="flex justify-between mt-1">
                                      <div>
                                          chave
                                      </div>
                                      <div>
                                          valor
                                      </div>
                                  </div>

                                  <div class="flex justify-between mt-1">
                                      <div>
                                          chave
                                      </div>
                                      <div>
                                          valor
                                      </div>
                                  </div>

                                  <div class="flex justify-between mt-1">
                                      <div>
                                          chave
                                      </div>
                                      <div>
                                          valor
                                      </div>
                                  </div>


                              </div>

                          </div>
                      </div>
                      <x-slot name="footerActions">

                      </x-slot>
                  </x-filament::modal>
              </div>
              <style>

              </style>

              {{-- end card kanban --}}
