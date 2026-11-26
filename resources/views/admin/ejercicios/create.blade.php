@extends('layouts.admin')

@section('title', 'Nuevo ejercicio')
@section('heading', 'Nuevo ejercicio: ' . $leccion->titulo)

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.lecciones.ejercicios.store', $leccion) }}" method="POST" novalidate>
        @csrf

        @include('admin.ejercicios._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.lecciones.ejercicios.index', $leccion) }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Crear ejercicio</button>
        </div>
    </form>

</div>

@endsection