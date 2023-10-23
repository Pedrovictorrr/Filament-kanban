<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PacoteHistoria extends Model
{
    use HasFactory;

    protected $fillable = ['historia_id','pacote_id'];

    protected $table = 'pacote_historia';

    public function historia(): BelongsTo
    {
        return $this->belongsTo(Historia::class);
    }
    
    public function pacote(): BelongsTo
    {
        return $this->belongsTo(Pacote::class);
    }
}
