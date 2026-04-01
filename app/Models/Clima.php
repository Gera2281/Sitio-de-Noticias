<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clima extends Model
{
    protected $table = 'clima';
    protected $fillable = ['imagen', 'titulo', 'descripcion', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
