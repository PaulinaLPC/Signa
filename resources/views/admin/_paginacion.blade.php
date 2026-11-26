{{-- Paginación reutilizable. Recibe: $paginador y $etiqueta --}}
<div class="admin-pagination">

    @if ($paginador->hasPages())
        <ul class="pagination">

            @if ($paginador->onFirstPage())
                <li class="disabled"><span>‹</span></li>
            @else
                <li><a href="{{ $paginador->previousPageUrl() }}">‹</a></li>
            @endif

            @foreach ($paginador->getUrlRange(1, $paginador->lastPage()) as $pagina => $url)
                @if ($pagina == $paginador->currentPage())
                    <li class="active"><span>{{ $pagina }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $pagina }}</a></li>
                @endif
            @endforeach

            @if ($paginador->hasMorePages())
                <li><a href="{{ $paginador->nextPageUrl() }}">›</a></li>
            @else
                <li class="disabled"><span>›</span></li>
            @endif

        </ul>
    @endif

    @if ($paginador->total() > 0)
        <p class="admin-pagination-info">
            Mostrando {{ $paginador->firstItem() }}–{{ $paginador->lastItem() }}
            de {{ $paginador->total() }} {{ $etiqueta }}
        </p>
    @endif

</div>