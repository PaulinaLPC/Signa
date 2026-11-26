@extends('layouts.app')

@section('title', 'Iniciar sesión | Signa')

@section('content')

<section class="auth-section">

    <div class="auth-card">

        <span class="eyebrow">BIENVENIDO DE NUEVO</span>

        <h1>Inicia sesión</h1>

        <p class="auth-subtitle">
            Continúa aprendiendo Lengua de Señas Mexicana donde te quedaste.
        </p>

        <form action="{{ route('login.store') }}" method="POST" class="auth-form" novalidate>
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="@error('email') input-error @enderror" autocomplete="email" required autofocus>
                @error('email') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       class="@error('password') input-error @enderror" autocomplete="current-password" required>
                @error('password') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <label class="form-check">
                <input type="checkbox" name="recordar" value="1">
                Mantener sesión iniciada
            </label>

            <button type="submit" class="auth-button">
                Entrar <span>→</span>
            </button>
        </form>

        <p class="auth-switch">
            ¿Aún no tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a>
        </p>

    </div>

</section>

@endsection