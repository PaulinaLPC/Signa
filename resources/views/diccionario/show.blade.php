@extends('layouts.app')

@section('title', $sena->palabra . ' | Diccionario Signa')

@section('content')

<section class="sign-detail">

    <a href="{{ route('diccionario.index') }}" class="back-link">← Volver al diccionario</a>

    <div class="sign-detail-grid">

        <!-- VIDEO O FOTOGRAFIA PRINCIPAL -->
        <div class="sign-media">

            @if ($sena->youtube_id)

                <div class="sign-video-embed">
                    <iframe
                        src="https://www.youtube-nocookie.com/embed/{{ $sena->youtube_id }}?rel=0"
                        title="Video de la seña {{ $sena->palabra }}"
                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>

            @elseif ($sena->video_url)

                <video src="{{ $sena->video_url }}" controls loop playsinline preload="metadata">
                    Tu navegador no puede reproducir este video.
                </video>

            @elseif ($sena->imagen_url)

                <img src="{{ $sena->imagen_url }}" alt="Seña de {{ $sena->palabra }}">

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

            {{-- Solo se muestra si se agregó una foto propia además del video --}}
            @if ($sena->tiene_video && $sena->imagen)
                <h2 class="sign-photo-title">Fotografía</h2>
                <img src="{{ $sena->imagen_url }}" alt="Fotografía de la seña {{ $sena->palabra }}" class="sign-photo">
            @endif

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