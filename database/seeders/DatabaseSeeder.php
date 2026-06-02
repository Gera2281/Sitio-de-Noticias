<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Ejecuta los seeders principales de la base de datos.
     */
    public function run(): void
    {
        // Llama al seeder de usuarios para poblar la base de datos con cuentas iniciales
        $this->call(UserSeeder::class);
    }
}
