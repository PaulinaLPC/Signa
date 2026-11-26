<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Sena;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiccionarioSeeder extends Seeder
{
    /*
    |--------------------------------------------------------------------------
    | Enlaces de multimedia
    |--------------------------------------------------------------------------
    | 'video'  → enlace de YouTube (ej. https://youtu.be/XXXXXXXXXXX)
    | 'imagen' → enlace de una imagen (opcional).
    |            Si se deja vacío, se usa la miniatura del video de YouTube.
    */
    private array $multimedia = [
        // Abecedario
        'a'        => ['video' => 'https://youtu.be/vXSSgzXJy1Q?si=z6I4meRYWhQkY3ZE', 'imagen' => ''],
        'b'        => ['video' => 'https://youtu.be/aK9Jfh69RXs?si=D3kl-UfeXUHyg0B-', 'imagen' => ''],
        'c'        => ['video' => 'https://youtu.be/JrwLI4P04_s?si=9gVVB3kWfFqIbqcx', 'imagen' => ''],

        // Números
        'uno'      => ['video' => 'https://youtu.be/5TCARa8YGAU?si=z59D2bM6jRp2eb3l', 'imagen' => ''],
        'dos'      => ['video' => 'https://youtu.be/5TCARa8YGAU?si=b33EYYap_HfesKTW', 'imagen' => ''],
        'tres'     => ['video' => 'https://youtu.be/5TCARa8YGAU?si=b33EYYap_HfesKTW', 'imagen' => ''],

        // Saludos
        'hola'     => ['video' => 'https://youtu.be/jXb4SCbeCwk?si=gSG-_kP4q_f26g2H', 'imagen' => ''],
        'adios'    => ['video' => 'https://youtu.be/tTLGh2NHuyw?si=F-79367aEKyT2jiW', 'imagen' => ''],
        'gracias'  => ['video' => 'https://youtu.be/n2Yu0llIvjM?si=dU1SpE0ITa9Pm71Q', 'imagen' => ''],

        // Familia
        'mama'     => ['video' => 'https://youtu.be/zrjnXTGAJmQ?si=Va71OKU9LYzdLyBH', 'imagen' => ''],
        'papa'     => ['video' => 'https://youtu.be/C_Ef-J4rOwA?si=paMrLdZyOI0Jkcnf', 'imagen' => ''],
        'hermano'  => ['video' => 'https://youtu.be/rRrQxMjeaAY?si=J3jgwT7UFLYCrUeV', 'imagen' => ''],

        // Animales
        'perro'    => ['video' => 'https://youtu.be/-nX1D2VwCY4?si=Srx3-SaXd1Omnxl1', 'imagen' => ''],
        'gato'     => ['video' => 'https://youtu.be/t6ZfVmisE30?si=XGcqPu9WeeE0qTND', 'imagen' => ''],
        'pajaro'   => ['video' => 'https://youtu.be/TftW1-_4oMI?si=C5gmAgojEPV-RycD', 'imagen' => ''],

        // Colores
        'rojo'     => ['video' => 'https://youtu.be/wfBFl2E7vxw?si=Wki2I3FgxfVgs0SW', 'imagen' => ''],
        'azul'     => ['video' => 'https://youtu.be/8YtUADPwWrA?si=kiqr7Nxgg_jfQD6g', 'imagen' => ''],
        'verde'    => ['video' => 'https://youtu.be/jfnNPCqAYV0?si=Jdi7vZ5n8YQGzMX6', 'imagen' => ''],

        // Alimentos
        'agua'     => ['video' => 'https://youtu.be/g8UY_02cOQ0?si=4FbZWVhMKezbjv2u', 'imagen' => ''],
        'leche'    => ['video' => 'https://youtu.be/_rfTycTJqAs?si=g6RWTHs3Uj7s0HWB', 'imagen' => ''],
        'manzana'  => ['video' => 'https://youtu.be/tNbbuCfOlvQ?si=FdkBxBjapt1m4uMu', 'imagen' => ''],

        // Emociones
        'alegria'  => ['video' => 'https://youtu.be/KPUJAwiwqQs?si=Z9VMcVGvU2_UvI45', 'imagen' => ''],
        'tristeza' => ['video' => 'https://youtu.be/2dpsT9RsQNE?si=-8YPQDkoo0qJCGyB', 'imagen' => ''],
        'enojo'    => ['video' => 'https://youtu.be/OUhTb45G0Lw?si=RxBaqiSQ2Qv1hWJS', 'imagen' => ''],
    ];

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
                $slug = Str::slug($palabra);

                Sena::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'categoria_id' => $categoria->id,
                        'palabra'      => $palabra,
                        'descripcion'  => 'Descripción pendiente de validar con una persona que conozca LSM.',
                        'imagen'       => $this->enlace($slug, 'imagen'),
                        'video'        => $this->enlace($slug, 'video'),
                    ]
                );
            }
        }
    }

    // Devuelve el enlace o null si está vacío
    private function enlace(string $slug, string $tipo): ?string
    {
        $valor = trim($this->multimedia[$slug][$tipo] ?? '');

        return $valor !== '' ? $valor : null;
    }
}