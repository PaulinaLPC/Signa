@extends('layouts.admin')

@section('title', 'Usuarios')
@section('heading', 'Usuarios')

@section('content')

<!-- FILTROS -->
<form action="{{ route('admin.usuarios.index') }}" method="GET" class="admin-filters">

    <input type="search" name="q" value="{{ $busqueda }}" placeholder="Buscar nombre o correo...">

    <select name="rol">
        <option value="">Todos los roles</option>
        <option value="estudiante" @selected($rol === 'estudiante')>Estudiantes</option>
        <option value="admin" @selected($rol === 'admin')>Administradores</option>
    </select>

    <button type="submit" class="admin-btn">Filtrar</button>

    @if ($busqueda || $rol)
        <a href="{{ route('admin.usuarios.index') }}" class="admin-btn">Limpiar</a>
    @endif

    <a href="{{ route('admin.usuarios.create') }}" class="admin-btn admin-btn-primary admin-filters-new">+ Nuevo usuario</a>

</form>

<!-- TABLA -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Lecciones completadas</th>
                <th>Registro</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
                <tr>
                    <td>
                        <div class="admin-user-cell">
                            <span class="admin-avatar">{{ mb_strtoupper(mb_substr($usuario->name, 0, 1)) }}</span>
                            <div>
                                <strong>{{ $usuario->name }}</strong>
                                <small>{{ $usuario->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge {{ $usuario->esAdmin() ? 'role-admin' : 'role-student' }}">
                            {{ $usuario->esAdmin() ? 'Administrador' : 'Estudiante' }}
                        </span>
                    </td>
                    <td>{{ $usuario->completadas_count }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td class="cell-actions">
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="admin-btn admin-btn-small">Editar</a>

                        @if (auth()->id() !== $usuario->id)
                            <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario? También se borrará su progreso.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-small admin-btn-danger">Eliminar</button>
                            </form>
                        @else
                            <span class="status status-ok">Tú</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="cell-empty">No se encontraron usuarios.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('admin._paginacion', ['paginador' => $usuarios, 'etiqueta' => 'usuarios'])
</div>

@endsection