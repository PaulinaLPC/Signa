@extends('layouts.app')

@section('title', 'Diccionario | Signa')

@section('content')

<!-- ENCABEZADO Y BUSCADOR -->
<section class="dic-hero">

    <span class="eyebrow">DICCIONARIO DE LSM</span>

    <h1>Busca una palabra y descubre su seña.</h1>

    <p>
        Consulta palabras de la Lengua de Señas Mexicana organizadas
        por categorías, con fotografías, videos y descripciones.
    </p>

    <form action="{{ route('diccionario.index') }}" method="GET" class="dic-search">

        @if ($categoriaActual)
            <input type="hidden" name="categoria" value="{{ $categoriaActual->slug }}">
        @endif

        <input
            type="search"
            name="q"
            value="{{ $busqueda }}"
            placeholder="Ej. Hola, Gracias, Mamá..."
            aria-label="Buscar una seña"
        >

        <button type="submit">Buscar</button>

    </form>

</section>


<!-- CATEGORIAS Y RESULTADOS -->
<section class="dic-content">

    <div class="dic-categories">

        <a href="{{ route('diccionario.index', array_filter(['q' => $busqueda])) }}"
           class="chip {{ $categoriaActual ? '' : 'chip-active' }}">
            Todas
        </a>

        @foreach ($categorias as $categoria)
            <a href="{{ route('diccionario.index', array_filter(['categoria' => $categoria->slug, 'q' => $busqueda])) }}"
               class="chip {{ $categoriaActual?->id === $categoria->id ? 'chip-active' : '' }}">
                {{ $categoria->icono }} {{ $categoria->nombre }}
                <small>{{ $categoria->senas_count }}</small>
            </a>
        @endforeach

    </div>

    <p class="dic-results">
        {{ $senas->count() }} {{ $senas->count() === 1 ? 'seña encontrada' : 'señas encontradas' }}
        @if ($busqueda)
            para "<strong>{{ $busqueda }}</strong>"
        @endif
        @if ($categoriaActual)
            en <strong>{{ $categoriaActual->nombre }}</strong>
        @endif
    </p>

    @if ($senas->isEmpty())

        <div class="dic-empty">
            <span>🔍</span>
            <p>No encontramos señas con esa búsqueda.</p>
            <a href="{{ route('diccionario.index') }}" class="chip chip-active">Ver todas las señas</a>
        </div>

    @else

        <div class="dic-grid">
            @foreach ($senas as $sena)
                @include('diccionario._tarjeta', ['item' => $sena])
            @endforeach
        </div>

    @endif

</section>

@endsection