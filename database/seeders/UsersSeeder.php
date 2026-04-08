<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'editor@test.com'],
            ['name' => 'Editor Test', 'password' => Hash::make('password'), 'role' => 'editor']
        );

        User::firstOrCreate(
            ['email' => 'revisor@test.com'],
            ['name' => 'Revisor Test', 'password' => Hash::make('password'), 'role' => 'revisor']
        );

        User::firstOrCreate(
            ['email' => 'lector@test.com'],
            ['name' => 'Lector Test', 'password' => Hash::make('password'), 'role' => 'espectador']
        );
    }
}
