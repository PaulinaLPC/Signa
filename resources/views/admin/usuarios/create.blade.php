@extends('layouts.admin')

@section('title', 'Nuevo usuario')
@section('heading', 'Nuevo usuario')

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.usuarios.store') }}" method="POST" novalidate>
        @csrf

        @include('admin.usuarios._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Crear usuario</button>
        </div>
    </form>

</div>

@endsection