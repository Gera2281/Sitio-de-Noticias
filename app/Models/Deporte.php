<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deporte extends Model
{
    // Define el nombre de la tabla en la base de datos
    protected $table = 'deportes';

    // Campos del modelo habilitados para asignación masiva
    protected $fillable = ['imagen', 'titulo', 'descripcion', 'contenido', 'user_id', 'status'];

    // Relacion:(Creador/Editor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
