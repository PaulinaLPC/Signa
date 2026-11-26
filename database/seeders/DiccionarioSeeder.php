<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Sena;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiccionarioSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            ['nombre' => 'Abecedario', 'icono' => '🔤', 'descripcion' => 'Letras del alfabeto manual de LSM.',     'senas' => ['A', 'B', 'C']],
            ['nombre' => 'Números',    'icono' => '🔢', 'descripcion' => 'Números básicos para contar.',           'senas' => ['Uno', 'Dos', 'Tres']],
            ['nombre' => 'Saludos',    'icono' => '👋', 'descripcion' => 'Expresiones para saludar y despedirse.', 'senas' => ['Hola', 'Adiós', 'Gracias']],
            ['nombre' => 'Familia',    'icono' => '👨‍👩‍👧', 'descripcion' => 'Miembros de la familia.',          'senas' => ['Mamá', 'Papá', 'Hermano']],
            ['nombre' => 'Animales',   'icono' => '🐶', 'descripcion' => 'Animales comunes.',                      'senas' => ['Perro', 'Gato', 'Pájaro']],
            ['nombre' => 'Colores',    'icono' => '🎨', 'descripcion' => 'Colores básicos.',                       'senas' => ['Rojo', 'Azul', 'Verde']],
            ['nombre' => 'Alimentos',  'icono' => '🍎', 'descripcion' => 'Comidas y bebidas.',                     'senas' => ['Agua', 'Leche', 'Manzana']],
            ['nombre' => 'Emociones',  'icono' => '💬', 'descripcion' => 'Sentimientos y estados de ánimo.',       'senas' => ['Alegría', 'Tristeza', 'Enojo']],
        ];

        foreach ($datos as $dato) {
            $categoria = Categoria::updateOrCreate(
                ['slug' => Str::slug($dato['nombre'])],
                [
                    'nombre'      => $dato['nombre'],
                    'descripcion' => $dato['descripcion'],
                    'icono'       => $dato['icono'],
                ]
            );

            foreach ($dato['senas'] as $palabra) {
                Sena::updateOrCreate(
                    ['slug' => Str::slug($palabra)],
                    [
                        'categoria_id' => $categoria->id,
                        'palabra'      => $palabra,
                        'descripcion'  => 'Descripción pendiente de validar con una persona que conozca LSM.',
                        'imagen'       => null,
                        'video'        => null,
                    ]
                );
            }
        }
    }
}