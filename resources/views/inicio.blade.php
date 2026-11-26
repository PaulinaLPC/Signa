@extends('layouts.app')

@section('title', 'Signa | Tus manos también hablan')

@section('content')

<!-- PRESENTACION PRINCIPAL -->
<section class="hero" id="inicio">

    <div class="hero-content">

        <span class="eyebrow">APRENDER UNA NUEVA FORMA DE COMUNICAR</span>

        <h1>
            Bienvenido a
            <span>Signa.</span>
        </h1>

        <h2>Aprender a comunicar también es aprender a incluir.</h2>

        <p>
            ¿Te gustaría aprender Lengua de Señas Mexicana?
            En Signa queremos acercarte a una nueva forma
            de comunicación mediante recursos visuales,
            contenido educativo y herramientas interactivas.
            Aprende a tu propio ritmo y descubre todo lo que
            puedes expresar con tus manos.
        </p>

        <p class="hero-extra">
            Creemos que la comunicación debe ser accesible
            para todos. Por eso, aprender LSM es un paso
            hacia una sociedad más inclusiva.
        </p>

        <a href="#como-funciona" class="start-button">
            Comenzar a aprender
            <span>→</span>
        </a>

    </div>

    <!-- COMPOSICION VISUAL -->
    <div class="hero-art">

        <span class="art-question">
            ¿Por dónde comenzamos?
            <span>↓</span>
        </span>

        <div class="visual-card card-blue">
            <span class="card-number">03</span>
            <div class="card-line"></div>
            <div class="card-decoration">ABC</div>
            <h3>Abecedario</h3>
            <p>Descubre las letras en LSM.</p>
        </div>

        <div class="visual-card card-pink">
            <span class="card-number">02</span>
            <div class="card-line"></div>
            <div class="card-decoration">01</div>
            <h3>Primeras palabras</h3>
            <p>Aprende nuevas expresiones.</p>
        </div>

        <div class="visual-card card-front">
            <span class="card-number">01</span>
            <div class="card-line"></div>

            <div class="hand-illustration">
                <span>🤟</span>
            </div>

            <h3>Comienza con una seña</h3>

            <p>
                Cada movimiento puede transmitir
                una idea, una palabra o una emoción.
            </p>

            <span class="card-tag">APRENDE A TU RITMO</span>
        </div>

    </div>

</section>


<!-- NOSOTROS -->
<section class="about-section" id="sobre-signa">

    <div class="about-title">
        <span class="eyebrow">CONOCE SIGNA</span>
        <h2>Una forma diferente de entender la comunicación.</h2>
    </div>

    <div class="about-description">
        <p>
            Signa es una plataforma educativa enfocada
            en el aprendizaje y difusión de la Lengua
            de Señas Mexicana.
        </p>

        <p>
            Nuestro propósito es acercar esta lengua
            a más personas mediante herramientas
            digitales accesibles y fáciles de utilizar.
        </p>
    </div>

</section>


<!-- CONOCENOS / COMO FUNCIONA -->
<section class="features-section" id="como-funciona">

    <div class="features-heading">
        <span class="eyebrow">DESCUBRE SIGNA</span>
        <h2>Aprende, descubre y comunica.</h2>
        <p>Explora diferentes recursos diseñados para acompañarte en tu aprendizaje.</p>
    </div>

    <div class="features-grid">

        <article class="feature feature-one">
            <span class="feature-icon">✳</span>
            <span class="feature-number">01 / EXPLORA</span>
            <h3>Descubre nuevas señas</h3>
            <p>Consulta palabras y conoce su representación mediante recursos visuales.</p>
        </article>

        <article class="feature feature-two">
            <span class="feature-icon">↗</span>
            <span class="feature-number">02 / APRENDE</span>
            <h3>Aprende a tu ritmo</h3>
            <p>Conoce conceptos y expresiones de la Lengua de Señas Mexicana.</p>
        </article>

        <article class="feature feature-three">
            <span class="feature-icon">♡</span>
            <span class="feature-number">03 / COMPARTE</span>
            <h3>Construye inclusión</h3>
            <p>Contribuye a una comunicación más accesible para todas las personas.</p>
        </article>

    </div>

</section>


<!-- MENSAJE FINAL -->
<section class="final-section">

    <span class="eyebrow">SIGNA · LSM</span>

    <h2>Porque todos tenemos algo que comunicar.</h2>

    <p>El primer paso para incluir es aprender a comunicarnos.</p>

    <a href="#inicio" class="final-button">Volver al inicio ↑</a>

</section>

@endsection