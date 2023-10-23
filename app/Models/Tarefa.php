<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefa';

    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'status',
        'historia_id',
        'commit_inicio',
        'commit_fim',
        'total_horas',
        'data_inicio',
        'data_fim',
        'data_QA',
        'dificuldade',
        'desenvolvedor_id'

    ];

    public function Historia()
    {
        return $this->belongsTo(Historia::class,'historia_id');
    }

    public function Desenvolvedor()
    {
        return $this->belongsTo(User::class,'desenvolvedor_id');
    }

    public function TarefaHoras()
    {
        return $this->hasMany(TarefaHoras::class,'tarefa_id');
    }
    // ENUNS //
    
    const STATUS_DEV = [
        'A_Fazer' => 'A Fazer',
        'Fazendo' => 'Fazendo',
        'Pausado' => 'Pausado',
        'Code_Review' => 'Code Review',
        'Feito' => 'Feito',
        'Qualidade' => 'Qualidade'
    ];

    const STATUS_QA = [
        'aberto' => 'Aberto',
        'andamento' => 'Andamento',
        'espera' => 'Espera',
        'pendente' => 'Pendente',
        'resolvido' => 'Resolvido',
        'fechado' => 'Fechado',
        'cancelado' => 'Cancelado',
        'concluido' => 'Concluido',
        'reaberto' => 'Reaberto',
        'em_espera_cliente' => 'Em espera'
    ];

    const STATUS_COLORS =  [
        'aberto' => 'green',
        'andamento' => 'gray',
        'espera' => 'zinc',
        'pendente' => 'neutral',
        'resolvido' => 'stone',
        'fechado' => 'red',
        'cancelado' => 'orange',
        'concluido' => 'amber',
        'reaberto' => 'yellow',
        'em_espera_cliente' => 'lime',
    ];

}
