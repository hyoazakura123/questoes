<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    use HasFactory;

    protected $table = 'questoes';

    protected $fillable = [
        'enunciado',
        'topico_id',
        'comentario',
    ];

    /*
     * Relacionamentos
     */


    public function topico()
    {
        return $this->belongsTo(Topico::class, 'topico_id');
    }

    public function alternativas()
    {
        return $this->hasMany(Alternativa::class, 'questao_id');
    }

    public function alternativaCorreta()
    {
        return $this->hasOne(Alternativa::class, 'questao_id')
                    ->where('correta', true);
    }
}
