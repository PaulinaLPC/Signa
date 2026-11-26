@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')

<!-- TARJETAS DE RESUMEN -->
<div class="admin-stats">

    <div class="admin-stat">
        <span>👥</span>
        <strong>{{ $estadisticas['usuarios'] }}</strong>
        <small>Usuarios ({{ $estadisticas['estudiantes'] }} estudiantes)</small>
    </div>

    <div class="admin-stat">
        <span>🗂️</span>
        <strong>{{ $estadisticas['categorias'] }}</strong>
        <small>Categorías</small>
    </div>

    <div class="admin-stat">
        <span>🤟</span>
        <strong>{{ $estadisticas['senas'] }}</strong>
        <small>Señas ({{ $estadisticas['senasSinVideo'] }} sin video)</small>
    </div>

    <div class="admin-stat">
        <span>📚</span>
        <strong>{{ $estadisticas['lecciones'] }}</strong>
        <small>Lecciones ({{ $estadisticas['completadas'] }} completadas)</small>
    </div>

</div>

<!-- ACCIONES RAPIDAS -->
<div class="admin-toolbar">
    <p>Accesos rápidos</p>
    <div class="admin-toolbar-actions">
        <a href="{{ route('admin.categorias.create') }}" class="admin-btn">+ Nueva categoría</a>
        <a href="{{ route('admin.senas.create') }}" class="admin-btn admin-btn-primary">+ Nueva seña</a>
    </div>
</div>

<div class="admin-grid-2">

    <!-- USUARIOS RECIENTES -->
    <div class="admin-card">
        <h2>Usuarios recientes</h2>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Registro</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuariosRecientes as $usuario)
                    <tr>
                        <td>
                            <strong>{{ $usuario->name }}</strong>
                            <small>{{ $usuario->email }}</small>
                        </td>
                        <td>
                            <span class="role-badge {{ $usuario->esAdmin() ? 'role-admin' : 'role-student' }}">
                                {{ $usuario->esAdmin() ? 'Admin' : 'Estudiante' }}
                            </span>
                        </td>
                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="cell-empty">Aún no hay usuarios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- SEÑAS SIN VIDEO -->
    <div class="admin-card">
        <h2>Señas sin video</h2>

        @if ($senasPendientes->isEmpty())
            <p class="cell-empty">🎉 Todas las señas tienen video.</p>
        @else
            <ul class="admin-list">
                @foreach ($senasPendientes as $sena)
                    <li>
                        <span>{{ $sena->categoria->icono }} {{ $sena->palabra }}</span>
                        <a href="{{ route('admin.senas.edit', $sena) }}" class="admin-btn admin-btn-small">
                            Agregar video
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>

@endsection