<?php

namespace App\Filament\Resources\HistoriaResource\Widgets;

use App\Models\Historia;
use Filament\Widgets\ChartWidget;

class HistoriaChart extends ChartWidget
{

    protected static ?string $heading = 'Relação total';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Historia::get();

        // Inicialize um array para armazenar as contagens de cada status
        $statusCounts = [];

        // Defina os valores iniciais para cada status
        foreach ([
            'aberto', 'andamento', 'espera', 'pendente',
            'resolvido', 'fechado', 'cancelado',
            'concluido', 'reaberto', 'em_espera_cliente'
        ] as $status) {
            $statusCounts[$status] = 0;
        }

        // Itere sobre os dados e conte a quantidade de cada status
        foreach ($data as $item) {
            $status = $item->status;
            if (isset($statusCounts[$status])) {
                $statusCounts[$status]++;
            }
        }

        // Crie os dados do gráfico com as contagens de cada status
        $chartData = [
            'datasets' => [
                [
                    'label' => 'Commits por dia',
                    'data' => array_values($statusCounts), // Valores das contagens
                    'backgroundColor' => [
                        'rgb(255, 99, 132,0.5)',
                        'rgb(54, 162, 235,0.5)',
                        '#dc2626',
                        '#14b8a6',
                        '#9333ea',
                        '#71717a',
                        '#f8fafc'
                    ],

                ],
            ],
            'labels' => array_keys($statusCounts), // Rótulos dos status
        ];

        return $chartData;
    }


    protected function getType(): string
    {
        return  'doughnut';
    }
}
