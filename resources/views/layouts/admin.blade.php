<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Panel') | Signa Admin</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Estilos de Signa -->
    <link rel="stylesheet" href="{{ asset('css/signa.css') }}">
</head>

<body class="admin-body">

<div class="admin-shell">

    <!-- MENU LATERAL -->
    <aside class="admin-sidebar">

        <a href="{{ route('admin.index') }}" class="brand admin-brand">
            <span class="brand-symbol">S</span>
            <span>Signa</span>
        </a>

        <span class="admin-sidebar-label">PANEL</span>

        <nav class="admin-nav">
            <a href="{{ route('admin.index') }}"
               class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.categorias.index') }}"
               class="{{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                🗂️ Categorías
            </a>

            <a href="{{ route('admin.senas.index') }}"
               class="{{ request()->routeIs('admin.senas.*') ? 'active' : '' }}">
                🤟 Señas
            </a>

            <span class="admin-nav-soon">👥 Usuarios <small>Pronto</small></span>
            <span class="admin-nav-soon">📚 Lecciones <small>Pronto</small></span>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="{{ route('inicio') }}">← Ver sitio</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>

    </aside>

    <!-- CONTENIDO -->
    <div class="admin-main">

        <header class="admin-topbar">
            <div>
                <span class="eyebrow">PANEL DE ADMINISTRACIÓN</span>
                <h1>@yield('heading', 'Panel')</h1>
            </div>

            <span class="admin-user">
                {{ auth()->user()->name }}
            </span>
        </header>

        @if (session('exito'))
            <div class="admin-alert admin-alert-success">{{ session('exito') }}</div>
        @endif

        @if (session('error'))
            <div class="admin-alert admin-alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')

    </div>

</div>

</body>
</html>