<li class="mb-5 mt-2 ml-6 flex">
    <x-filament::fieldset width="full" class="flex-1"
        style="padding: 1px!important; ">
        <x-slot name="label">
            <div class="flex">
                <x-filament::badge color='primary' class="ml-3"
                    style="margin-right: 5px!important">
                    {{ $tarefa->Desenvolvedor->roles[0]->title }}
                </x-filament::badge>
                <x-filament::badge color='warning' class="ml-3">
                    Insert de horas
                </x-filament::badge>
            </div>
        </x-slot>
        <div class="flex justify-between">
            <div class="flex p-1">
                <x-filament::avatar class="rounded-full" size="w-7 h-7"
                    src="{{  str_replace('public/', '/storage/', $tarefa->Desenvolvedor->avatar_url) }}"
                    alt="Dan Harrin" />
                <div class="text-sm"
                    style="margin-left: 3px; margin-top: 3px!important">
                    <strong>{{ $tarefa->Desenvolvedor->name }}</strong>
                </div>
            </div>
            <div class="text-sm"
                style="color:rgb(141, 141, 141); margin-right: 5px!important;">
                {{ $tarefa->created_at }}
            </div>
        </div>
        <div class="p-2  text-xs" style="padding: 15px!important">
            {!! $tarefa->descricao !!}
        </div>
    </x-filament::fieldset>
</li>