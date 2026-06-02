<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Campos del modelo que pueden ser asignados masivamente
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'especialidad',
        'password',
        'role', // Rol de usuario (ej. editor, revisor)
    ];

    /**
     * Campos que deben ocultarse cuando el modelo es convertido a JSON o arreglos (Seguridad)
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión o "casteo" automático de tipos de atributos al recuperarlos de la base de datos
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Las contraseñas se hashean automáticamente
        ];
    }
}
