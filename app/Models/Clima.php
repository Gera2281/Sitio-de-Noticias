<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clima extends Model
{
    // Define el nombre de la tabla en la base de datos
    protected $table = 'clima';

    // Campos del modelo  
    protected $fillable = ['imagen', 'titulo', 'descripcion', 'contenido', 'user_id', 'status'];

    // Relacion:(Creador/Editor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
