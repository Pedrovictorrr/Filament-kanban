<?php

namespace App\Filament\Resources\HistoriaResource\Widgets;

use App\Models\Historia;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;

class HistoriaViewChart extends ChartWidget
{

    public ?Model $record = null;

    protected static ?string $heading = 'Aberturas';



    protected function getData(): array
    {
        $data = Historia::get();

        // Inicialize um array para armazenar as contagens de abertos por mês
        $abertosPorMes = [];

        // Itere sobre os dados e conte quantos foram abertos por mês
        foreach ($data as $item) {
            $dataAbertura = strtotime($item->created_at); // Suponha que a data de abertura esteja em um campo chamado "data_abertura"
            $mesAno = date('M Y', $dataAbertura); // Formato "M Y" para representar mês e ano

            if (!isset($abertosPorMes[$mesAno])) {
                $abertosPorMes[$mesAno] = 0;
            }
            $abertosPorMes[$mesAno]++;
        }

        // Crie os dados do gráfico com as contagens de abertos por mês
        $chartData = [
            'datasets' => [
                [
                    'label' => 'Abertos por Mês',
                    'data' => array_values($abertosPorMes), // Valores das contagens

                ],
            ],
            'labels' => array_keys($abertosPorMes), // Rótulos dos meses e anos
        ];

        return $chartData;
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
{
    return [
        'plugins' => [
            'legend' => [
                'options'=> [
                    'indexAxis'=> 'y',
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    'elements' => [
                      'bar'=>[
                        'borderWidth'=> 2,
            ]
                ],
            ],
        ],
        ]
    ];
}

    protected static ?string $maxHeight = '300px';
}
