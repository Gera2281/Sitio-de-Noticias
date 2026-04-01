<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Espectador',
            'email' => 'espectador@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'espectador',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'editor',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Revisor',
            'email' => 'revisor@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'revisor',
        ]);
    }
}
