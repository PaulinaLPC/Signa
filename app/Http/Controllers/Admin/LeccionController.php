<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Ejercicio;
use App\Models\Leccion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LeccionController extends Controller
{
    public const NIVELES = ['Principiante', 'Básico', 'Intermedio', 'Avanzado'];

    public function index()
    {
        $lecciones = Leccion::with('categoria')
            ->withCount([
                'ejercicios',
                'progresos as completadas_count' => fn ($query) => $query->where('completada', true),
            ])
            ->orderBy('orden')
            ->get();

        return view('admin.lecciones.index', compact('lecciones'));
    }

    public function create()
    {
        return view('admin.lecciones.create', [
            'leccion'    => new Leccion([
                'nivel' => 'Principiante',
                'orden' => (int) Leccion::max('orden') + 1,
            ]),
            'categorias' => Categoria::orderBy('nombre')->get(),
            'niveles'    => self::NIVELES,
        ]);
    }

    public function store(Request $request)
    {
        $leccion = Leccion::create($this->validar($request));

        return redirect()
            ->route('admin.lecciones.ejercicios.index', $leccion)
            ->with('exito', 'Lección creada. Ahora agrega sus ejercicios.');
    }

    public function edit(Leccion $leccion)
    {
        return view('admin.lecciones.edit', [
            'leccion'    => $leccion,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'niveles'    => self::NIVELES,
        ]);
    }

    public function update(Request $request, Leccion $leccion)
    {
        $leccion->update($this->validar($request, $leccion));

        return redirect()
            ->route('admin.lecciones.index')
            ->with('exito', 'Lección actualizada correctamente.');
    }

    public function destroy(Leccion $leccion)
    {
        // También se eliminan sus ejercicios y el progreso de los estudiantes
        $leccion->delete();

        return back()->with('exito', 'Lección eliminada correctamente.');
    }

    // Crea un ejercicio por cada seña de la categoría que todavía no tenga uno
    public function generarEjercicios(Leccion $leccion)
    {
        if (! $leccion->categoria) {
            return back()->with('error', 'La lección no tiene categoría. Asígnale una para generar ejercicios.');
        }

        $senas = $leccion->categoria->senas()->orderBy('id')->get();

        if ($senas->count() < 2) {
            return back()->with('error', 'La categoría necesita al menos 2 señas para generar ejercicios.');
        }

        $palabras = $senas->pluck('palabra');
        $orden = (int) $leccion->ejercicios()->max('orden');
        $creados = 0;

        foreach ($senas as $sena) {
            if ($leccion->ejercicios()->where('sena_id', $sena->id)->exists()) {
                continue;
            }

            // La respuesta correcta + hasta 3 palabras de la misma categoría
            $opciones = $palabras
                ->reject(fn ($palabra) => $palabra === $sena->palabra)
                ->shuffle()
                ->take(3)
                ->push($sena->palabra)
                ->values()
                ->all();

            Ejercicio::create([
                'leccion_id' => $leccion->id,
                'sena_id'    => $sena->id,
                'pregunta'   => '¿Qué palabra representa esta seña?',
                'opciones'   => $opciones,
                'respuesta'  => $sena->palabra,
                'orden'      => ++$orden,
            ]);

            $creados++;
        }

        return back()->with(
            'exito',
            $creados > 0
                ? "Se crearon {$creados} ejercicios nuevos."
                : 'Todas las señas de la categoría ya tienen ejercicio.'
        );
    }

    // Validación compartida entre crear y editar
    private function validar(Request $request, ?Leccion $leccion = null): array
    {
        $datos = $request->validate([
            'titulo'       => ['required', 'string', 'max:120'],
            'categoria_id' => ['nullable', 'exists:categorias,id'],
            'nivel'        => ['required', Rule::in(self::NIVELES)],
            'orden'        => ['required', 'integer', 'min:0'],
            'descripcion'  => ['nullable', 'string', 'max:255'],
            'contenido'    => ['nullable', 'string', 'max:5000'],
        ], [
            'titulo.required' => 'Escribe el título de la lección.',
            'titulo.max'      => 'El título no puede tener más de 120 caracteres.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'nivel.required'  => 'Selecciona un nivel.',
            'nivel.in'        => 'El nivel seleccionado no es válido.',
            'orden.required'  => 'Escribe el orden de la lección.',
            'orden.integer'   => 'El orden debe ser un número.',
            'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
            'contenido.max'   => 'El contenido es demasiado largo.',
        ]);

        $slug = Str::slug($datos['titulo']);

        $existe = Leccion::where('slug', $slug)
            ->when($leccion, fn ($query) => $query->where('id', '!=', $leccion->id))
            ->exists();

        if ($existe) {
            throw ValidationException::withMessages([
                'titulo' => 'Ya existe una lección con ese título.',
            ]);
        }

        $datos['slug'] = $slug;

        return $datos;
    }
}