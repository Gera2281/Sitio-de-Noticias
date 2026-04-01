<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    protected $fillable = ['imagen', 'titulo', 'descripcion', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
