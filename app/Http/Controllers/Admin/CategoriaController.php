<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('senas')
            ->orderBy('nombre')
            ->get();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create', [
            'categoria' => new Categoria(),
        ]);
    }

    public function store(Request $request)
    {
        Categoria::create($this->validar($request));

        return redirect()
            ->route('admin.categorias.index')
            ->with('exito', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $categoria->update($this->validar($request, $categoria));

        return redirect()
            ->route('admin.categorias.index')
            ->with('exito', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        // Evita borrar señas por accidente
        if ($categoria->senas()->exists()) {
            return back()->with('error', 'No puedes eliminar una categoría que tiene señas. Primero mueve o elimina sus señas.');
        }

        $categoria->delete();

        return back()->with('exito', 'Categoría eliminada correctamente.');
    }

    // Validación compartida entre crear y editar
    private function validar(Request $request, ?Categoria $categoria = null): array
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:80', Rule::unique('categorias', 'nombre')->ignore($categoria?->id)],
            'icono'       => ['nullable', 'string', 'max:10'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'Escribe el nombre de la categoría.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',
            'nombre.max'      => 'El nombre no puede tener más de 80 caracteres.',
            'icono.max'       => 'El ícono es demasiado largo.',
            'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
        ]);

        $slug = Str::slug($datos['nombre']);

        $existe = Categoria::where('slug', $slug)
            ->when($categoria, fn ($query) => $query->where('id', '!=', $categoria->id))
            ->exists();

        if ($existe) {
            throw ValidationException::withMessages([
                'nombre' => 'Ya existe una categoría con un nombre muy parecido.',
            ]);
        }

        $datos['slug'] = $slug;

        return $datos;
    }
}