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
     */
    public function run(): void
    {
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');

        User::updateOrCreate(
            ['email' => $username . '@bdatos.com'],
            [
                'name'     => $username,
                'email'    => $username . '@bdatos.com',
                'password' => \Illuminate\Support\Facades\Hash::make($password),
            ]
        );
    }
}
