@extends('layouts.admin')

@section('title', 'Editar categoría')
@section('heading', 'Editar categoría: ' . $categoria->nombre)

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        @include('admin.categorias._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.categorias.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar cambios</button>
        </div>
    </form>

</div>

@endsection