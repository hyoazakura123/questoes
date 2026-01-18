<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternativa extends Model
{
    use HasFactory;

    protected $table = 'alternativas';

    protected $fillable = [
        'questao_id',
        'texto',
        'correta',
        'comentario',
    ];

    protected $casts = [
        'correta' => 'boolean',
    ];

    /*
     * Relacionamentos
     */

    public function questao()
    {
        return $this->belongsTo(Questao::class, 'questao_id');
    }
}
