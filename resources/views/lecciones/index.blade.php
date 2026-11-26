@extends('layouts.app')

@section('title', 'Mis lecciones | Signa')

@section('content')

<!-- ENCABEZADO Y PROGRESO GENERAL -->
<section class="lessons-hero">

    <span class="eyebrow">MIS LECCIONES</span>

    <h1>Aprende paso a paso.</h1>

    <p>Avanza por las lecciones, observa cada seña y pon a prueba lo que aprendiste.</p>

    <div class="progress-summary">
        <div class="progress-bar">
            <span style="width: {{ $porcentaje }}%"></span>
        </div>
        <p>
            <strong>{{ $porcentaje }}%</strong> completado ·
            {{ $completadas }} de {{ $lecciones->count() }} lecciones
        </p>
    </div>

</section>


<!-- LISTA DE LECCIONES -->
<section class="lessons-content">

    @if ($lecciones->isEmpty())

        <div class="dic-empty">
            <span>📚</span>
            <p>Aún no hay lecciones disponibles.</p>
        </div>

    @else

        <div class="lessons-grid">

            @foreach ($lecciones as $leccion)

                @php $progreso = $progresos->get($leccion->id); @endphp

                <a href="{{ route('lecciones.show', $leccion->slug) }}"
                   class="lesson-card {{ $progreso?->completada ? 'lesson-done' : '' }}">

                    <div class="lesson-card-top">
                        <span class="lesson-number">{{ str_pad($leccion->orden, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="lesson-level">{{ $leccion->nivel }}</span>
                    </div>

                    <span class="lesson-icon">{{ $leccion->categoria?->icono ?? '📘' }}</span>

                    <h3>{{ $leccion->titulo }}</h3>

                    <p>{{ $leccion->descripcion }}</p>

                    <div class="lesson-status">
                        @if ($progreso?->completada)
                            ✓ Completada · {{ $progreso->aciertos }}/{{ $progreso->total }}
                        @elseif ($progreso)
                            En progreso · {{ $progreso->aciertos }}/{{ $progreso->total }}
                        @else
                            {{ $leccion->ejercicios_count }} ejercicios
                        @endif
                    </div>

                </a>

            @endforeach

        </div>

    @endif

</section>

@endsection