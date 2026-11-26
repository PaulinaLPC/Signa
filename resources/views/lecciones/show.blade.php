@extends('layouts.app')

@section('title', $leccion->titulo . ' | Lecciones Signa')

@section('content')

<section class="lesson-detail">

    <a href="{{ route('lecciones.index') }}" class="back-link">← Volver a mis lecciones</a>

    <!-- RESULTADO DE LOS EJERCICIOS -->
    @if (session('resultado'))

        @php $resultado = session('resultado'); @endphp

        <div class="result-box {{ $resultado['aprobada'] ? 'result-pass' : 'result-fail' }}">

            <div>
                <h2>
                    {{ $resultado['aprobada'] ? '¡Muy bien! Lección completada 🎉' : 'Sigue practicando 💪' }}
                </h2>
                <p>
                    Obtuviste <strong>{{ $resultado['aciertos'] }} de {{ $resultado['total'] }}</strong>
                    respuestas correctas.
                    @unless ($resultado['aprobada'])
                        Necesitas al menos 60% para completar la lección.
                    @endunless
                </p>
            </div>

            <ul class="result-list">
                @foreach ($resultado['detalle'] as $item)
                    <li class="{{ $item['correcta'] ? 'ok' : 'bad' }}">
                        {{ $item['correcta'] ? '✓' : '✗' }} {{ $item['palabra'] }}
                        @unless ($item['correcta'])
                            <small>(elegiste: {{ $item['elegida'] }})</small>
                        @endunless
                    </li>
                @endforeach
            </ul>

        </div>

    @endif

    <!-- ENCABEZADO DE LA LECCION -->
    <div class="lesson-header">

        <span class="chip chip-active">
            {{ $leccion->categoria?->icono }} {{ $leccion->nivel }}
        </span>

        <h1>{{ $leccion->titulo }}</h1>

        <p>{{ $leccion->contenido }}</p>

        @if ($progreso)
            <p class="lesson-progress-note">
                {{ $progreso->completada ? '✓ Completaste esta lección' : 'Tu mejor resultado' }}:
                {{ $progreso->aciertos }}/{{ $progreso->total }}
            </p>
        @endif

    </div>

    <!-- SEÑAS DE LA LECCION -->
    <h2 class="lesson-subtitle">Señas de esta lección</h2>

    @if ($senas->isEmpty())
        <div class="dic-empty">
            <span>📘</span>
            <p>Esta lección todavía no tiene señas.</p>
        </div>
    @else
        <div class="dic-grid">
            @foreach ($senas as $sena)
                @include('diccionario._tarjeta', ['item' => $sena])
            @endforeach
        </div>
    @endif

    <!-- LLAMADO A LOS EJERCICIOS -->
    @if ($leccion->ejercicios_count > 0)

        <div class="cta-box">
            <div>
                <h2>¿Listo para practicar?</h2>
                <p>
                    Resuelve {{ $leccion->ejercicios_count }} ejercicios.
                    Necesitas al menos 60% de aciertos para completar la lección.
                </p>
            </div>

            <a href="{{ route('lecciones.ejercicios', $leccion->slug) }}" class="auth-button">
                Hacer ejercicios <span>→</span>
            </a>
        </div>

    @endif

</section>

@endsection