<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ejercicio;
use App\Models\Leccion;
use App\Models\Sena;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EjercicioController extends Controller
{
    public function index(Leccion $leccion)
    {
        $leccion->load('categoria');

        $ejercicios = $leccion->ejercicios()->with('sena.categoria')->get();

        return view('admin.ejercicios.index', compact('leccion', 'ejercicios'));
    }

    public function create(Leccion $leccion)
    {
        return view('admin.ejercicios.create', [
            'leccion'   => $leccion,
            'ejercicio' => new Ejercicio([
                'pregunta' => '¿Qué palabra representa esta seña?',
                'orden'    => (int) $leccion->ejercicios()->max('orden') + 1,
            ]),
            'senas'     => $this->senasDisponibles(),
        ]);
    }

    public function store(Request $request, Leccion $leccion)
    {
        $datos = $this->validar($request);
        $datos['leccion_id'] = $leccion->id;

        Ejercicio::create($datos);

        return redirect()
            ->route('admin.lecciones.ejercicios.index', $leccion)
            ->with('exito', 'Ejercicio creado correctamente.');
    }

    public function edit(Leccion $leccion, Ejercicio $ejercicio)
    {
        return view('admin.ejercicios.edit', [
            'leccion'   => $leccion,
            'ejercicio' => $ejercicio,
            'senas'     => $this->senasDisponibles(),
        ]);
    }

    public function update(Request $request, Leccion $leccion, Ejercicio $ejercicio)
    {
        $ejercicio->update($this->validar($request));

        return redirect()
            ->route('admin.lecciones.ejercicios.index', $leccion)
            ->with('exito', 'Ejercicio actualizado correctamente.');
    }

    public function destroy(Leccion $leccion, Ejercicio $ejercicio)
    {
        $ejercicio->delete();

        return back()->with('exito', 'Ejercicio eliminado correctamente.');
    }

    // Señas agrupadas por categoría para el selector
    private function senasDisponibles()
    {
        return Sena::with('categoria')
            ->orderBy('categoria_id')
            ->orderBy('palabra')
            ->get()
            ->groupBy(fn ($sena) => $sena->categoria->nombre);
    }

    private function validar(Request $request): array
    {
        $datos = $request->validate([
            'sena_id'   => ['nullable', 'exists:senas,id'],
            'pregunta'  => ['required', 'string', 'max:255'],
            'opciones'  => ['required', 'string'],
            'respuesta' => ['required', 'string', 'max:100'],
            'orden'     => ['required', 'integer', 'min:0'],
        ], [
            'sena_id.exists'     => 'La seña seleccionada no existe.',
            'pregunta.required'  => 'Escribe la pregunta.',
            'opciones.required'  => 'Escribe las opciones, una por línea.',
            'respuesta.required' => 'Escribe la respuesta correcta.',
            'orden.required'     => 'Escribe el orden.',
            'orden.integer'      => 'El orden debe ser un número.',
        ]);

        // Convierte el texto (una opción por línea) en una lista sin vacíos ni repetidos
        $opciones = collect(preg_split('/\r\n|\r|\n/', $datos['opciones']))
            ->map(fn ($opcion) => trim($opcion))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (count($opciones) < 2) {
            throw ValidationException::withMessages([
                'opciones' => 'Escribe al menos 2 opciones, una por línea.',
            ]);
        }

        $respuesta = trim($datos['respuesta']);

        if (! in_array($respuesta, $opciones, true)) {
            throw ValidationException::withMessages([
                'respuesta' => 'La respuesta correcta debe ser exactamente una de las opciones.',
            ]);
        }

        return [
            'sena_id'   => $datos['sena_id'] ?? null,
            'pregunta'  => $datos['pregunta'],
            'opciones'  => $opciones,
            'respuesta' => $respuesta,
            'orden'     => $datos['orden'],
        ];
    }
}