<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistoria extends Model
{
    use HasFactory;

    protected $table = 'status_historia';

    protected $fillable = ['nome', 'descricao'];

    public function Historia()
    {
        return $this->hasMany(Historia::class, 'id');
    }
}
