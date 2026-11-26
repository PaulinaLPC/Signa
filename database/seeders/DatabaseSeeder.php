<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador para pruebas
        User::updateOrCreate(
            ['email' => 'admin@signa.com'],
            [
                'name'     => 'Administrador Signa',
                'password' => Hash::make('admin12345'),
                'rol'      => 'admin',
            ]
        );

        // Módulo 2: categorías y señas
        $this->call(DiccionarioSeeder::class);

        // Módulo 3: lecciones y ejercicios (depende del diccionario)
        $this->call(LeccionSeeder::class);
    }
}