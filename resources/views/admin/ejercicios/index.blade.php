@extends('layouts.admin')

@section('title', 'Ejercicios: ' . $leccion->titulo)
@section('heading', 'Ejercicios: ' . $leccion->titulo)

@section('content')

<div class="admin-toolbar">
    <a href="{{ route('admin.lecciones.index') }}" class="admin-btn">← Volver a lecciones</a>

    <div class="admin-toolbar-actions">
        @if ($leccion->categoria)
            <form action="{{ route('admin.lecciones.generar', $leccion) }}" method="POST">
                @csrf
                <button type="submit" class="admin-btn">
                    ⚡ Generar desde señas de {{ $leccion->categoria->nombre }}
                </button>
            </form>
        @endif

        <a href="{{ route('admin.lecciones.ejercicios.create', $leccion) }}" class="admin-btn admin-btn-primary">
            + Nuevo ejercicio
        </a>
    </div>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Seña</th>
                <th>Pregunta</th>
                <th>Opciones</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ejercicios as $ejercicio)
                <tr>
                    <td><strong>{{ $ejercicio->orden }}</strong></td>
                    <td>
                        @if ($ejercicio->sena)
                            <div class="admin-user-cell">
                                <div class="admin-thumb">
                                    @if ($ejercicio->sena->imagen_url)
                                        <img src="{{ $ejercicio->sena->imagen_url }}" alt="{{ $ejercicio->sena->palabra }}">
                                    @else
                                        <span>{{ $ejercicio->sena->categoria->icono }}</span>
                                    @endif
                                </div>
                                <div>
                                    <strong>{{ $ejercicio->sena->palabra }}</strong>
                                    <small>{{ $ejercicio->sena->tiene_video ? 'Con video' : 'Sin video' }}</small>
                                </div>
                            </div>
                        @else
                            <span class="status status-missing">Sin seña</span>
                        @endif
                    </td>
                    <td>{{ $ejercicio->pregunta }}</td>
                    <td>
                        <div class="admin-chips">
                            @foreach ($ejercicio->opciones as $opcion)
                                <span class="admin-chip {{ $opcion === $ejercicio->respuesta ? 'admin-chip-correct' : '' }}">
                                    {{ $opcion === $ejercicio->respuesta ? '✓ ' : '' }}{{ $opcion }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="cell-actions">
                        <a href="{{ route('admin.lecciones.ejercicios.edit', [$leccion, $ejercicio]) }}" class="admin-btn admin-btn-small">Editar</a>

                        <form action="{{ route('admin.lecciones.ejercicios.destroy', [$leccion, $ejercicio]) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este ejercicio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-small admin-btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="cell-empty">
                        Esta lección no tiene ejercicios.
                        @if ($leccion->categoria)
                            Usa "Generar desde señas" o crea uno manualmente.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection