@extends('layouts.admin')

@section('title', 'Lecciones')
@section('heading', 'Lecciones')

@section('content')

<div class="admin-toolbar">
    <p>{{ $lecciones->count() }} lecciones registradas</p>
    <a href="{{ route('admin.lecciones.create') }}" class="admin-btn admin-btn-primary">+ Nueva lección</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Orden</th>
                <th>Lección</th>
                <th>Nivel</th>
                <th>Ejercicios</th>
                <th>Completada por</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lecciones as $leccion)
                <tr>
                    <td><strong>{{ str_pad($leccion->orden, 2, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>
                        <strong>{{ $leccion->categoria?->icono }} {{ $leccion->titulo }}</strong>
                        <small>{{ $leccion->categoria?->nombre ?? 'Sin categoría' }}</small>
                    </td>
                    <td><span class="lesson-level">{{ $leccion->nivel }}</span></td>
                    <td>
                        @if ($leccion->ejercicios_count > 0)
                            {{ $leccion->ejercicios_count }}
                        @else
                            <span class="status status-missing">Sin ejercicios</span>
                        @endif
                    </td>
                    <td>{{ $leccion->completadas_count }} estudiantes</td>
                    <td class="cell-actions">
                        <a href="{{ route('admin.lecciones.ejercicios.index', $leccion) }}" class="admin-btn admin-btn-small">Ejercicios</a>
                        <a href="{{ route('admin.lecciones.edit', $leccion) }}" class="admin-btn admin-btn-small">Editar</a>

                        <form action="{{ route('admin.lecciones.destroy', $leccion) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta lección? También se borrarán sus ejercicios y el progreso de los estudiantes.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-small admin-btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="cell-empty">No hay lecciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection