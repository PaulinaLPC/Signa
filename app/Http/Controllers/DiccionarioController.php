<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Sena;
use Illuminate\Http\Request;

class DiccionarioController extends Controller
{
    // Lista de señas con buscador y filtro por categoría
    public function index(Request $request)
    {
        $busqueda = trim($request->input('q', ''));
        $categoriaSlug = $request->input('categoria');

        $categorias = Categoria::withCount('senas')
            ->orderBy('nombre')
            ->get();

        $categoriaActual = $categoriaSlug
            ? $categorias->firstWhere('slug', $categoriaSlug)
            : null;

        $senas = Sena::with('categoria')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where('palabra', 'like', "%{$busqueda}%");
            })
            ->when($categoriaActual, function ($query) use ($categoriaActual) {
                $query->where('categoria_id', $categoriaActual->id);
            })
            ->orderBy('palabra')
            ->get();

        return view('diccionario.index', compact('senas', 'categorias', 'categoriaActual', 'busqueda'));
    }

    // Ficha de una seña
    public function show(Sena $sena)
    {
        $sena->load('categoria');

        $relacionadas = Sena::with('categoria')
            ->where('categoria_id', $sena->categoria_id)
            ->where('id', '!=', $sena->id)
            ->orderBy('palabra')
            ->take(4)
            ->get();

        return view('diccionario.show', compact('sena', 'relacionadas'));
    }
}