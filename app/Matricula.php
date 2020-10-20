<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = [
        'id_aluno',
        'id_turma',
        'nota_primeiro_bimestre',
        'nota_segundo_bimestre',
        'nota_terceiro_bimestre',
        'nota_quarto_bimestre',
    ];
}
