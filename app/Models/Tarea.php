<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'atendido',
        'entrega',
    ];

    // protected $guarded = ['id', 'timestamps'];
}
