@extends('layouts.admin')

@section('title', 'Nueva lección')
@section('heading', 'Nueva lección')

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.lecciones.store') }}" method="POST" novalidate>
        @csrf

        @include('admin.lecciones._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.lecciones.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Crear lección</button>
        </div>
    </form>

</div>

@endsection