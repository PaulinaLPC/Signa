<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Sena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SenaController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim($request->input('q', ''));
        $categoriaId = $request->input('categoria');

        $senas = Sena::with('categoria')
            ->when($busqueda !== '', fn ($query) => $query->where('palabra', 'like', "%{$busqueda}%"))
            ->when($categoriaId, fn ($query) => $query->where('categoria_id', $categoriaId))
            ->orderBy('palabra')
            ->paginate(12)
            ->withQueryString();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.senas.index', compact('senas', 'categorias', 'busqueda', 'categoriaId'));
    }

    public function create()
    {
        return view('admin.senas.create', [
            'sena'       => new Sena(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        $datos['imagen'] = $this->procesarImagen($request, null);

        Sena::create($datos);

        return redirect()
            ->route('admin.senas.index')
            ->with('exito', 'Seña creada correctamente.');
    }

    public function edit(Sena $sena)
    {
        return view('admin.senas.edit', [
            'sena'       => $sena,
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Sena $sena)
    {
        $datos = $this->validar($request, $sena);
        $datos['imagen'] = $this->procesarImagen($request, $sena->imagen);

        $sena->update($datos);

        return redirect()
            ->route('admin.senas.index')
            ->with('exito', 'Seña actualizada correctamente.');
    }

    public function destroy(Sena $sena)
    {
        $this->borrarArchivo($sena->imagen);
        $sena->delete();

        return back()->with('exito', 'Seña eliminada correctamente.');
    }

    // Validación compartida entre crear y editar
    private function validar(Request $request, ?Sena $sena = null): array
    {
        $datos = $request->validate([
            'categoria_id'   => ['required', 'exists:categorias,id'],
            'palabra'        => ['required', 'string', 'max:100'],
            'descripcion'    => ['nullable', 'string', 'max:2000'],
            'video'          => ['nullable', 'url', 'max:255'],
            'imagen_url'     => ['nullable', 'url', 'max:255'],
            'imagen_archivo' => ['nullable', 'image', 'max:2048'],
        ], [
            'categoria_id.required' => 'Selecciona una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no existe.',
            'palabra.required'      => 'Escribe la palabra de la seña.',
            'palabra.max'           => 'La palabra no puede tener más de 100 caracteres.',
            'video.url'             => 'Escribe un enlace válido (por ejemplo, de YouTube).',
            'imagen_url.url'        => 'Escribe un enlace de imagen válido.',
            'imagen_archivo.image'  => 'El archivo debe ser una imagen (JPG, PNG o WebP).',
            'imagen_archivo.max'    => 'La imagen no puede pesar más de 2 MB.',
        ]);

        $slug = Str::slug($datos['palabra']);

        $existe = Sena::where('slug', $slug)
            ->when($sena, fn ($query) => $query->where('id', '!=', $sena->id))
            ->exists();

        if ($existe) {
            throw ValidationException::withMessages([
                'palabra' => 'Ya existe una seña con esa palabra.',
            ]);
        }

        return [
            'categoria_id' => $datos['categoria_id'],
            'palabra'      => $datos['palabra'],
            'slug'         => $slug,
            'descripcion'  => $datos['descripcion'] ?? null,
            'video'        => $datos['video'] ?? null,
        ];
    }

    // Decide qué imagen guardar: archivo subido, enlace, quitarla o dejar la actual
    private function procesarImagen(Request $request, ?string $actual): ?string
    {
        if ($request->hasFile('imagen_archivo')) {
            $this->borrarArchivo($actual);
            return $request->file('imagen_archivo')->store('senas', 'public');
        }

        if ($request->filled('imagen_url')) {
            $this->borrarArchivo($actual);
            return $request->input('imagen_url');
        }

        if ($request->boolean('quitar_imagen')) {
            $this->borrarArchivo($actual);
            return null;
        }

        return $actual;
    }

    // Borra la imagen del disco solo si fue subida al proyecto (no si es un enlace)
    private function borrarArchivo(?string $ruta): void
    {
        if ($ruta && ! Str::startsWith($ruta, ['http://', 'https://'])) {
            Storage::disk('public')->delete($ruta);
        }
    }
}