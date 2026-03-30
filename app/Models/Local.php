<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    protected $fillable = ['imagen', 'titulo', 'descripcion'];

    
}
