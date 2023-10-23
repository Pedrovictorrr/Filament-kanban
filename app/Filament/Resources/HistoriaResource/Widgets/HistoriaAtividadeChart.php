<?php

namespace App\Filament\Resources\HistoriaResource\Widgets;

use Filament\Widgets\ChartWidget;

class HistoriaAtividadeChart extends ChartWidget
{


    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [ 2,10],

                ],
            ],
            'labels' => [ 'Horas usadas','Horas restantes'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }


}
