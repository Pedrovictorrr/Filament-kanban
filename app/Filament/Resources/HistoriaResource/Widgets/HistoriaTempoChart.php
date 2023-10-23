<?php

namespace App\Filament\Resources\HistoriaResource\Widgets;

use Filament\Widgets\ChartWidget;

class HistoriaTempoChart extends ChartWidget
{

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [2, 10],
                    'backgroundColor' => ['rgb(220, 38, 38,0.3)', 'rgb(37, 99, 235,0.3)',],
                    
                ],
            ],
            'labels' => ['Horas usadas', 'Horas restantes'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
