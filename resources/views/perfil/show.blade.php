@extends('layouts.app')

@section('title', 'Mi perfil | Signa')

@section('content')

<section class="profile-section">

    <!-- ENCABEZADO DEL PERFIL -->
    <div class="profile-header">

        <div class="profile-avatar">
            {{ mb_strtoupper(mb_substr($usuario->name, 0, 1)) }}
        </div>

        <div class="profile-identity">
            <span class="eyebrow">MI PERFIL</span>
            <h1>{{ $usuario->name }}</h1>
            <p>{{ $usuario->email }}</p>
        </div>

        <span class="role-badge {{ $usuario->esAdmin() ? 'role-admin' : 'role-student' }}">
            {{ $usuario->esAdmin() ? 'Administrador' : 'Estudiante' }}
        </span>

    </div>

    <div class="profile-grid">

        <!-- DATOS PERSONALES -->
        <div class="profile-card">

            <h2>Mis datos</h2>

            <form action="{{ route('perfil.update') }}" method="POST" class="auth-form" novalidate>
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}"
                           class="@error('name') input-error @enderror" required>
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}"
                           class="@error('email') input-error @enderror" required>
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="auth-button">Guardar cambios</button>
            </form>

            <p class="profile-meta">
                Miembro desde el {{ $usuario->created_at->format('d/m/Y') }}
            </p>

        </div>

        <!-- MI APRENDIZAJE -->
        <div class="profile-card profile-card-learning">

            <h2>Mi aprendizaje</h2>

            <div class="progress-bar">
                <span style="width: {{ $porcentaje }}%"></span>
            </div>

            <div class="profile-stats">
                <div>
                    <strong>{{ $completadas }}/{{ $totalLecciones }}</strong>
                    <span>Lecciones</span>
                </div>
                <div>
                    <strong>{{ $aciertos }}</strong>
                    <span>Aciertos</span>
                </div>
                <div>
                    <strong>{{ $porcentaje }}%</strong>
                    <span>Progreso</span>
                </div>
            </div>

            <a href="{{ route('lecciones.index') }}" class="chip chip-active">
                Ir a mis lecciones →
            </a>

        </div>

    </div>

</section>

@endsection