<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarefaHoras extends Model
{
    use HasFactory;

    protected $fillable  = ['horas_trabalhadas','comentario','user_id','tarefa_id','status'];

    public function Tarefa()
    {
        return $this->belongsTo(Tarefa::class,'tarefa_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
