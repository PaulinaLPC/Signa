@extends('layouts.app')

@section('title', 'Crear cuenta | Signa')

@section('content')

<section class="auth-section">

    <div class="auth-card">

        <span class="eyebrow">ÚNETE A SIGNA</span>

        <h1>Crea tu cuenta</h1>

        <p class="auth-subtitle">
            Regístrate para acceder a lecciones, ejercicios y guardar tu progreso.
        </p>

        <form action="{{ route('registro.store') }}" method="POST" class="auth-form" novalidate>
            @csrf

            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="@error('name') input-error @enderror" autocomplete="name" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="@error('email') input-error @enderror" autocomplete="email" required>
                @error('email') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       class="@error('password') input-error @enderror" autocomplete="new-password" required>
                <small class="form-hint">Mínimo 8 caracteres.</small>
                @error('password') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       autocomplete="new-password" required>
            </div>

            <button type="submit" class="auth-button">
                Crear cuenta <span>→</span>
            </button>
        </form>

        <p class="auth-switch">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </p>

    </div>

</section>

@endsection