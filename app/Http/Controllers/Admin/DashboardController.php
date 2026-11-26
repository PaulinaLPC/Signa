<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Leccion;
use App\Models\Progreso;
use App\Models\Sena;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $estadisticas = [
            'usuarios'      => User::count(),
            'estudiantes'   => User::where('rol', 'estudiante')->count(),
            'categorias'    => Categoria::count(),
            'senas'         => Sena::count(),
            'senasSinVideo' => Sena::whereNull('video')->count(),
            'lecciones'     => Leccion::count(),
            'completadas'   => Progreso::where('completada', true)->count(),
        ];

        $usuariosRecientes = User::latest()->take(5)->get();

        $senasPendientes = Sena::with('categoria')
            ->whereNull('video')
            ->orderBy('palabra')
            ->take(8)
            ->get();

        return view('admin.index', compact('estadisticas', 'usuariosRecientes', 'senasPendientes'));
    }
}