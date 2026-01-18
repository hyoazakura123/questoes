<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topico extends Model
{
    use HasFactory;

    protected $table = 'topicos';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    /*
     * Relacionamento
     * Um tópico possui várias questões
     */
    public function questoes()
    {
        return $this->hasMany(Questao::class, 'topico_id');
    }
}
