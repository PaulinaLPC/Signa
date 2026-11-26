@extends('layouts.admin')

@section('title', 'Nueva seña')
@section('heading', 'Nueva seña')

@section('content')

<div class="admin-card admin-form-card">

    <form action="{{ route('admin.senas.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        @include('admin.senas._form')

        <div class="admin-form-actions">
            <a href="{{ route('admin.senas.index') }}" class="admin-btn">Cancelar</a>
            <button type="submit" class="admin-btn admin-btn-primary">Guardar seña</button>
        </div>
    </form>

</div>

@endsection