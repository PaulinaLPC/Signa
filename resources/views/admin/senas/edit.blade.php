@extends('layouts.admin')

@section('title', 'Editar seña')
@section('heading', 'Editar seña: ' . $sena->palabra)

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.senas.update', $sena) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        @include('admin.senas._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.senas.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar cambios</button>
        </div>
    </form>

</div>

@endsection