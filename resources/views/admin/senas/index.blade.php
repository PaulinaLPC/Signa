@extends('layouts.admin')

@section('title', 'Señas')
@section('heading', 'Señas')

@section('content')

<!-- FILTROS -->
<form action="{{ route('admin.senas.index') }}" method="GET" class="admin-filters">

    <input type="search" name="q" value="{{ $busqueda }}" placeholder="Buscar palabra...">

    <select name="categoria">
        <option value="">Todas las categorías</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" @selected($categoriaId == $categoria->id)>
                {{ $categoria->icono }} {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="admin-btn">Filtrar</button>

    @if ($busqueda || $categoriaId)
        <a href="{{ route('admin.senas.index') }}" class="admin-btn">Limpiar</a>
    @endif

    <a href="{{ route('admin.senas.create') }}" class="admin-btn admin-btn-primary admin-filters-new">+ Nueva seña</a>

</form>

<!-- TABLA -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Palabra</th>
                <th>Categoría</th>
                <th>Video</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($senas as $sena)
                <tr>
                    <td>
                        <div class="admin-thumb">
                            @if ($sena->imagen_url)
                                <img src="{{ $sena->imagen_url }}" alt="{{ $sena->palabra }}">
                            @else
                                <span>{{ $sena->categoria->icono }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong>{{ $sena->palabra }}</strong>
                        <small>{{ $sena->slug }}</small>
                    </td>
                    <td>{{ $sena->categoria->nombre }}</td>
                    <td>
                        @if ($sena->youtube_id)
                            <span class="status status-ok">YouTube</span>
                        @elseif ($sena->video_url)
                            <span class="status status-ok">Video</span>
                        @else
                            <span class="status status-missing">Sin video</span>
                        @endif
                    </td>
                    <td class="cell-actions">
                        <a href="{{ route('diccionario.show', $sena->slug) }}" target="_blank" class="admin-btn admin-btn-small">Ver</a>
                        <a href="{{ route('admin.senas.edit', $sena) }}" class="admin-btn admin-btn-small">Editar</a>

                        <form action="{{ route('admin.senas.destroy', $sena) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta seña?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-small admin-btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="cell-empty">No se encontraron señas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

        <div class="admin-pagination">

        @if ($senas->hasPages())

            <ul class="pagination">

                {{-- Anterior --}}
                @if ($senas->onFirstPage())
                    <li class="disabled"><span>‹</span></li>
                @else
                    <li><a href="{{ $senas->previousPageUrl() }}">‹</a></li>
                @endif

                {{-- Números de página --}}
                @foreach ($senas->getUrlRange(1, $senas->lastPage()) as $pagina => $url)
                    @if ($pagina == $senas->currentPage())
                        <li class="active"><span>{{ $pagina }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $pagina }}</a></li>
                    @endif
                @endforeach

                {{-- Siguiente --}}
                @if ($senas->hasMorePages())
                    <li><a href="{{ $senas->nextPageUrl() }}">›</a></li>
                @else
                    <li class="disabled"><span>›</span></li>
                @endif

            </ul>

        @endif

        @if ($senas->total() > 0)
            <p class="admin-pagination-info">
                Mostrando {{ $senas->firstItem() }}–{{ $senas->lastItem() }} de {{ $senas->total() }} señas
            </p>
        @endif

    </div>
</div>

@endsection