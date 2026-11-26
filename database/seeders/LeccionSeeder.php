<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Ejercicio;
use App\Models\Leccion;
use Illuminate\Database\Seeder;

class LeccionSeeder extends Seeder
{
    // Nivel de cada lección según el slug de su categoría
    private array $niveles = [
        'abecedario' => 'Principiante',
        'numeros'    => 'Principiante',
        'saludos'    => 'Principiante',
        'familia'    => 'Básico',
        'animales'   => 'Básico',
        'colores'    => 'Básico',
        'alimentos'  => 'Intermedio',
        'emociones'  => 'Intermedio',
    ];

    public function run(): void
    {
        $orden = 1;

        $categorias = Categoria::with(['senas' => fn ($query) => $query->orderBy('id')])
            ->orderBy('id')
            ->get();

        foreach ($categorias as $categoria) {

            $leccion = Leccion::updateOrCreate(
                ['slug' => $categoria->slug],
                [
                    'categoria_id' => $categoria->id,
                    'titulo'       => $categoria->nombre,
                    'descripcion'  => "Aprende las señas de la categoría {$categoria->nombre}.",
                    'contenido'    => "En esta lección conocerás las señas de la categoría {$categoria->nombre}. "
                                    . "Observa con atención cada video, repite el movimiento frente a un espejo "
                                    . "y, cuando te sientas listo, resuelve los ejercicios para completar la lección.",
                    'nivel'        => $this->niveles[$categoria->slug] ?? 'Principiante',
                    'orden'        => $orden++,
                ]
            );

            // Las opciones de cada ejercicio son las palabras de la misma categoría
            $palabras = $categoria->senas->pluck('palabra')->all();

            foreach ($categoria->senas->values() as $indice => $sena) {
                Ejercicio::updateOrCreate(
                    [
                        'leccion_id' => $leccion->id,
                        'sena_id'    => $sena->id,
                    ],
                    [
                        'pregunta'  => '¿Qué palabra representa esta seña?',
                        'opciones'  => $palabras,
                        'respuesta' => $sena->palabra,
                        'orden'     => $indice + 1,
                    ]
                );
            }
        }
    }
}