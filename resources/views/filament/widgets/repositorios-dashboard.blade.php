<x-filament-widgets::widget>
    <x-filament::section collapsible>
        <x-slot name="heading">
            Suas atividades no Git
        </x-slot>


        <ul class=" space-y-1 text-gray-500 list-inside dark:text-gray-400">
            @foreach ($GitRepositorios as $git)
                <li class="flex items-center">
                    <svg style="margin-right: 3"
                        class="w-3.5 h-3.5 mr-2 ml-2 pr-2 text-green-500 text-green-400 flex-shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="green" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    - <strong>{{ $git['type'] }}</strong>
                    - {{ $git['repo']['name'] }}

                    @if (isset($git['payload']['description']) && !empty($git['payload']['description']))
                        - {{ $git['payload']['description'] }}
                    @else
                    @endif
                    @if ($git['type'] == 'CreateEvent')
                        - <strong> {{ $git['payload']['ref_type'] }} </strong>
                    @endif
                    - {{ \Carbon\Carbon::parse($git['created_at'])->format('d/m/Y H:i:s') }}
                </li>
            @endforeach
        </ul>


    </x-filament::section>
</x-filament-widgets::widget>
