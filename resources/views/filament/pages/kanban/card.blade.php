<x-filament::section>
    <div class="text-xs flex justify-between">
        <div class="mt-1 flex" style="color: rgb(171, 171, 171)">
            <x-filament::icon alias="panels::topbar.global-search.field" icon="heroicon-o-ellipsis-horizontal-circle"
                class="h-5 w-5" color='green' />
            <div style="padding-top: 2px!important"> # {{ $tarefa->Historia->titulo }}</div>
        </div>
        <div>
            <x-filament::avatar class="rounded-full"
                src="{{  str_replace('public/', '/storage/', $tarefa->Desenvolvedor->avatar_url) }}" alt="Dan Harrin"
                size='h-6 w-6' />
        </div>
    </div>
    <div class="text-sm  flex justify-start text-start" style="margin-left: 5px!important">{{ $tarefa->titulo }}
    </div>
    <div class="flex justify-end mt-3">
        @if ($tarefa->Historia->prioridade == 'normal')
            <x-filament::badge color='success' class="ml-3">
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
</x-filament::section>

<style>
    .fi-section-content {
        padding: 3px !important;
    }
</style>
