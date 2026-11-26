<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Signa | Lengua de Señas Mexicana')</title>

    <meta name="description" content="Signa, plataforma educativa de Lengua de Señas Mexicana.">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Estilos de Signa -->
    <link rel="stylesheet" href="{{ asset('css/signa.css') }}">
</head>

<body>

    <header class="header">

        <a href="{{ route('inicio') }}" class="brand">
            <span class="brand-symbol">S</span>
            <span>Signa</span>
        </a>

        <nav class="navigation">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('inicio') }}#sobre-signa">Nosotros</a>
            <a href="{{ route('diccionario.index') }}">Diccionario</a>

            @auth
                <a href="{{ route('lecciones.index') }}">Lecciones</a>

                @if (auth()->user()->esAdmin())
                    <a href="{{ route('admin.index') }}">Panel</a>
                @endif
            @else
                <a href="{{ route('inicio') }}#como-funciona">Conócenos</a>
            @endauth
        </nav>

        <div class="header-actions">
            @auth
                <a href="{{ route('perfil') }}" class="header-link">
                    Hola, {{ explode(' ', auth()->user()->name)[0] }}
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="header-button">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header-link">Iniciar sesión</a>

                <a href="{{ route('registro') }}" class="header-button">
                    Registrarse <span>↗</span>
                </a>
            @endauth
        </div>

    </header>

    @if (session('exito'))
        <div class="alert alert-success">
            {{ session('exito') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer">

        <a href="{{ route('inicio') }}" class="brand">
            <span class="brand-symbol">S</span>
            <span>Signa</span>
        </a>

        <div class="footer-info">
            <p>La comunicación nos conecta.</p>
            <p>Universidad Tecnológica de Tecámac · Desarrollo de Software Multiplataforma</p>
        </div>

        <small>
            © {{ date('Y') }} Signa. Proyecto educativo sobre LSM.
        </small>

    </footer>

</body>
</html>