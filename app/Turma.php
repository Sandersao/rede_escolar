<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = [
        'serie',
        'ano',
        'letra_identificadora',
        'fk_escola',
    ];
}
