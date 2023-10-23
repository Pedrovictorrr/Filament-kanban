<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pacote extends Model
{
    use HasFactory;

    protected $table = 'pacote';

    protected $fillable = ['nome', 'horas_previstas'];



    public function PacoteHistoria(): HasMany
    {
        return $this->hasMany(PacoteHistoria::class);
    }
    public function Historia()
    {
        return $this->belongsToMany(Historia::class,'pacote_historia');
    }
}
