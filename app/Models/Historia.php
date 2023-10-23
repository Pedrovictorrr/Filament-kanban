<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Historia extends Model
{
    use HasFactory;

    protected $table = 'historia';

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'total_horas',
        'data_previsao_cliente',
        'data_previsao_qa',
        'anexos',
        'horas_previstas',
        'prioridade',
        'tipo_historia',
        'projeto_id',
        'pacote_id',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function Tarefa()
    {
        return $this->hasMany(Tarefa::class, 'historia_id');
    }

    public function PacoteHistoria(): HasMany
    {
        return $this->hasMany(PacoteHistoria::class);
    }

    public function TipoHistoria()
    {
        return $this->belongsTo(TipoHistoria::class, 'tipo_historia');
    }

    // ENUMS //

    const STATUS = [
        'nova' => 'Nova',
        'andamento' => 'Andamento',
        'liberar' => 'Liberar',
        'concluido' => 'Concluido',
    ];

    const STATUS_COLORS = [
        'nova' => 'info',
        'andamento' => 'primary',
        'liberar' => 'gray',
        'concluido' => 'success',
    ];

    const PRIORIDADE = [
        'urgente' => 'Urgente',
        'normal' => 'Normal',
    ];

    const PRIORIDADE_COLORS = [
        'urgente' => 'danger',
        'normal' => 'success',
    ];
}
