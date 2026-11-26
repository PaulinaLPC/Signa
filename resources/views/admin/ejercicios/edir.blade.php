@extends('layouts.admin')

@section('title', 'Editar ejercicio')
@section('heading', 'Editar ejercicio: ' . $leccion->titulo)

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.lecciones.ejercicios.update', [$leccion, $ejercicio]) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        @include('admin.ejercicios._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.lecciones.ejercicios.index', $leccion) }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar cambios</button>
        </div>
    </form>

</div>

@endsection