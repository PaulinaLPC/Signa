@extends('layouts.app')

@section('title', 'Panel de administración | Signa')

@section('content')

<section class="auth-section">

    <div class="auth-card">

        <span class="eyebrow">ÁREA PRIVADA</span>

        <h1>Panel de administración</h1>

        <p class="auth-subtitle">
            Solo los usuarios con rol de administrador pueden ver esta página.
            Aquí se construirá el Módulo 4: gestión de usuarios, categorías,
            señas, lecciones y contenido.
        </p>

        <a href="{{ route('perfil') }}" class="auth-button">Ir a mi perfil</a>

    </div>

</section>

@endsection