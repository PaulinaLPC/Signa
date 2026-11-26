@extends('layouts.admin')

@section('title', 'Categorías')
@section('heading', 'Categorías')

@section('content')

<div class="admin-toolbar">
    <p>{{ $categorias->count() }} categorías registradas</p>
    <a href="{{ route('admin.categorias.create') }}" class="admin-btn admin-btn-primary">+ Nueva categoría</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ícono</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Señas</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categorias as $categoria)
                <tr>
                    <td class="cell-icon">{{ $categoria->icono }}</td>
                    <td>
                        <strong>{{ $categoria->nombre }}</strong>
                        <small>{{ $categoria->slug }}</small>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($categoria->descripcion, 60) }}</td>
                    <td>{{ $categoria->senas_count }}</td>
                    <td class="cell-actions">
                        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="admin-btn admin-btn-small">
                            Editar
                        </a>

                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-small admin-btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="cell-empty">No hay categorías registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection