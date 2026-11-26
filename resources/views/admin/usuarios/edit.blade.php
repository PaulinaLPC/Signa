@extends('layouts.admin')

@section('title', 'Editar usuario')
@section('heading', 'Editar usuario: ' . $usuario->name)

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        @include('admin.usuarios._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar cambios</button>
        </div>
    </form>

</div>

@endsection