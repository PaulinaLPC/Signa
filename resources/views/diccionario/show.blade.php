@extends('layouts.app')

@section('title', $sena->palabra . ' | Diccionario Signa')

@section('content')

<section class="sign-detail">

    <a href="{{ route('diccionario.index') }}" class="back-link">← Volver al diccionario</a>

    <div class="sign-detail-grid">

        <!-- FOTOGRAFIA O VIDEO -->
        <div class="sign-media">

            @if ($sena->video)
                <video
                    src="{{ asset($sena->video) }}"
                    controls
                    preload="metadata"
                    @if ($sena->imagen) poster="{{ asset($sena->imagen) }}" @endif
                ></video>
            @elseif ($sena->imagen)
                <img src="{{ asset($sena->imagen) }}" alt="Seña de {{ $sena->palabra }}">
            @else
                <div class="sign-media-empty">
                    <span>{{ $sena->categoria->icono }}</span>
                    <p>Fotografía y video próximamente.</p>
                </div>
            @endif

        </div>

        <!-- INFORMACION -->
        <div class="sign-info">

            <a href="{{ route('diccionario.index', ['categoria' => $sena->categoria->slug]) }}" class="chip chip-active">
                {{ $sena->categoria->icono }} {{ $sena->categoria->nombre }}
            </a>

            <h1>{{ $sena->palabra }}</h1>

            <h2>¿Cómo se realiza?</h2>

            <p>{{ $sena->descripcion ?? 'Descripción no disponible por el momento.' }}</p>

        </div>

    </div>

    <!-- SEÑAS RELACIONADAS -->
    @if ($relacionadas->isNotEmpty())

        <div class="related">

            <h2>Más señas de {{ $sena->categoria->nombre }}</h2>

            <div class="dic-grid">
                @foreach ($relacionadas as $relacionada)
                    @include('diccionario._tarjeta', ['item' => $relacionada])
                @endforeach
            </div>

        </div>

    @endif

</section>

@endsection