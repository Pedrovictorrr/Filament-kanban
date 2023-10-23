<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHistoria extends Model
{
    use HasFactory;

    protected $table = 'tipo_historia';

    protected $fillable = ['nome', 'descricao'];

    public function Historia()
    {
        return $this->hasMany(Historia::class, 'id');
    }
}
