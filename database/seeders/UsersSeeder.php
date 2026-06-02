<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para crear usuarios de prueba con el método firstOrCreate.
     */
    public function run(): void
    {
        // Crear un usuario con el rol de Editor para pruebas si no existe
        User::firstOrCreate(
            ['email' => 'editor@test.com'],
            ['name' => 'Editor Test', 'password' => Hash::make('password'), 'role' => 'editor']
        );

        // Crear un usuario con el rol de Revisor para pruebas si no existe
        User::firstOrCreate(
            ['email' => 'revisor@test.com'],
            ['name' => 'Revisor Test', 'password' => Hash::make('password'), 'role' => 'revisor']
        );

        // Crear un usuario con el rol de Espectador (Lector) para pruebas si no existe
        User::firstOrCreate(
            ['email' => 'lector@test.com'],
            ['name' => 'Lector Test', 'password' => Hash::make('password'), 'role' => 'espectador']
        );
    }
}
