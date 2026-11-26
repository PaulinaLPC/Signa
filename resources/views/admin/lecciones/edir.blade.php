@extends('layouts.admin')

@section('title', 'Editar lección')
@section('heading', 'Editar lección: ' . $leccion->titulo)

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.lecciones.update', $leccion) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        @include('admin.lecciones._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.lecciones.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar cambios</button>
        </div>
    </form>

</div>

@endsection