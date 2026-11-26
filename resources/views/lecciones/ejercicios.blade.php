@extends('layouts.app')

@section('title', 'Ejercicios: ' . $leccion->titulo . ' | Signa')

@section('content')

<section class="exercise-section">

    <a href="{{ route('lecciones.show', $leccion->slug) }}" class="back-link">← Volver a la lección</a>

    <div class="exercise-header">
        <span class="eyebrow">EJERCICIOS · {{ mb_strtoupper($leccion->titulo) }}</span>
        <h1>Observa la seña y elige la palabra correcta.</h1>
    </div>

    @if ($errors->any())
        <div class="form-alert">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('lecciones.calificar', $leccion->slug) }}" method="POST" class="exercise-form">
        @csrf

        @foreach ($ejercicios as $ejercicio)

            <article class="exercise-card">

                <span class="exercise-number">
                    Pregunta {{ $loop->iteration }} de {{ $ejercicios->count() }}
                </span>

                <div class="exercise-media">
                    @include('lecciones._media', ['sena' => $ejercicio->sena])
                </div>

                <h3>{{ $ejercicio->pregunta }}</h3>

                <div class="exercise-options">
                    @foreach (collect($ejercicio->opciones)->shuffle() as $opcion)
                        <label class="option">
                            <input
                                type="radio"
                                name="respuestas[{{ $ejercicio->id }}]"
                                value="{{ $opcion }}"
                                @checked(old("respuestas.{$ejercicio->id}") === $opcion)
                                required
                            >
                            <span>{{ $opcion }}</span>
                        </label>
                    @endforeach
                </div>

            </article>

        @endforeach

        <button type="submit" class="auth-button exercise-submit">
            Calificar mis respuestas <span>→</span>
        </button>

    </form>

</section>

@endsection