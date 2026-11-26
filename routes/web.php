<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DiccionarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\SenaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\LeccionController as AdminLeccionController;
use App\Http\Controllers\Admin\EjercicioController;

// Módulo 1: Página de presentación
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Módulo 2: Diccionario de LSM
Route::get('/diccionario', [DiccionarioController::class, 'index'])->name('diccionario.index');
Route::get('/diccionario/{sena:slug}', [DiccionarioController::class, 'show'])->name('diccionario.show');

// Módulo 3: Usuarios (solo para visitantes sin sesión)
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.store');
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'iniciarSesion'])->name('login.store');
});

// Módulo 3: Usuarios y aprendizaje (solo con sesión iniciada)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

    Route::get('/lecciones', [LeccionController::class, 'index'])->name('lecciones.index');
    Route::get('/lecciones/{leccion:slug}', [LeccionController::class, 'show'])->name('lecciones.show');
    Route::get('/lecciones/{leccion:slug}/ejercicios', [LeccionController::class, 'ejercicios'])->name('lecciones.ejercicios');
    Route::post('/lecciones/{leccion:slug}/ejercicios', [LeccionController::class, 'calificar'])->name('lecciones.calificar');
});

// Módulo 4: Panel de administración (solo administradores)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('categorias', CategoriaController::class)
        ->except('show')
        ->parameters(['categorias' => 'categoria']);

    Route::resource('senas', SenaController::class)
        ->except('show')
        ->parameters(['senas' => 'sena']);

    Route::resource('usuarios', UsuarioController::class)
        ->except('show')
        ->parameters(['usuarios' => 'usuario']);

    Route::resource('lecciones', AdminLeccionController::class)
        ->except('show')
        ->parameters(['lecciones' => 'leccion']);

    Route::post('lecciones/{leccion}/generar-ejercicios', [AdminLeccionController::class, 'generarEjercicios'])
        ->name('lecciones.generar');

    // Ejercicios dentro de cada lección: /admin/lecciones/{leccion}/ejercicios
    Route::resource('lecciones.ejercicios', EjercicioController::class)
        ->except('show')
        ->parameters(['lecciones' => 'leccion', 'ejercicios' => 'ejercicio'])
        ->scoped();
});