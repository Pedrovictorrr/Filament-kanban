<?php

namespace Database\Seeders;

use App\Models\TipoHistoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoHistoriaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoHistoria::create([
            'nome' => 'Relatório de Horas',
            'descricao' => 'Sem previsão, será cobrado as horas realizadas;'
        ]);

        TipoHistoria::create([
            'nome' => 'Implantação',
            'descricao' => 'Somente para cliente novo, projeto sendo construído;'
        ]);

        TipoHistoria::create([
            'nome' => 'Customização',
            'descricao' => 'Orçamento aprovado com valor fechado;'
        ]);

        TipoHistoria::create([
            'nome' => 'Contrato',
            'descricao' => 'Cliente com contrato de sustentação;'
        ]);

        TipoHistoria::create([
            'nome' => 'Correção',
            'descricao' => 'Não será cobrado horas do cliente;'
        ]);
    }
}
