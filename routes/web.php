<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DiccionarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;

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

// Módulo 3: Usuarios (solo con sesión iniciada)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
});