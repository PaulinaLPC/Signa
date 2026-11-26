<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DiccionarioController;

// Módulo 1: Página de presentación
Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Módulo 2: Diccionario de LSM
Route::get('/diccionario', [DiccionarioController::class, 'index'])->name('diccionario.index');
Route::get('/diccionario/{sena:slug}', [DiccionarioController::class, 'show'])->name('diccionario.show');