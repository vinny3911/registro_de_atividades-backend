<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    protected $table = 'atividades';
    protected $fillable = ['nome', 'descricao', 'data', 'hora_inicio', 'hora_termino', 'recorrencia'];
}
