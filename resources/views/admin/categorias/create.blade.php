@extends('layouts.admin')

@section('title', 'Nueva categoría')
@section('heading', 'Nueva categoría')

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.categorias.store') }}" method="POST" novalidate>
        @csrf

        @include('admin.categorias._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.categorias.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar categoría</button>
        </div>
    </form>

</div>

@endsection