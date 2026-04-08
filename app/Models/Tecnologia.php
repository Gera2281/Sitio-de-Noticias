<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    protected $table = 'tecnologia';

    protected $fillable = [
        'imagen',
        'titulo',
        'descripcion',
        'contenido',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}