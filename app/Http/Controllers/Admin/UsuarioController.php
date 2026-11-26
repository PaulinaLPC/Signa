<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    private const ROLES = ['estudiante', 'admin'];

    public function index(Request $request)
    {
        $busqueda = trim($request->input('q', ''));
        $rol = $request->input('rol');

        $usuarios = User::withCount([
                'progresos as completadas_count' => fn ($query) => $query->where('completada', true),
            ])
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($sub) use ($busqueda) {
                    $sub->where('name', 'like', "%{$busqueda}%")
                        ->orWhere('email', 'like', "%{$busqueda}%");
                });
            })
            ->when(in_array($rol, self::ROLES, true), fn ($query) => $query->where('rol', $rol))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.usuarios.index', compact('usuarios', 'busqueda', 'rol'));
    }

    public function create()
    {
        return view('admin.usuarios.create', [
            'usuario' => new User(['rol' => 'estudiante']),
        ]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'rol'      => ['required', Rule::in(self::ROLES)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $this->mensajes());

        User::create($datos); // la contraseña se encripta automáticamente

        return redirect()
            ->route('admin.usuarios.index')
            ->with('exito', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($usuario->id)],
            'rol'      => ['required', Rule::in(self::ROLES)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], $this->mensajes());

        // Protecciones para no quedarse sin administradores
        if ($datos['rol'] !== 'admin') {
            if ($usuario->id === $request->user()->id) {
                throw ValidationException::withMessages([
                    'rol' => 'No puedes quitarte a ti mismo el rol de administrador.',
                ]);
            }

            if ($this->esUltimoAdmin($usuario)) {
                throw ValidationException::withMessages([
                    'rol' => 'Debe existir al menos un administrador.',
                ]);
            }
        }

        // Si la contraseña se deja vacía, se conserva la actual
        if (empty($datos['password'])) {
            unset($datos['password']);
        }

        $usuario->update($datos);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('exito', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $usuario)
    {
        if ($usuario->id === $request->user()->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta desde el panel.');
        }

        if ($this->esUltimoAdmin($usuario)) {
            return back()->with('error', 'No puedes eliminar al único administrador.');
        }

        $usuario->delete();

        return back()->with('exito', 'Usuario eliminado correctamente.');
    }

    private function esUltimoAdmin(User $usuario): bool
    {
        return $usuario->esAdmin() && User::where('rol', 'admin')->count() <= 1;
    }

    private function mensajes(): array
    {
        return [
            'name.required'      => 'Escribe el nombre.',
            'name.max'           => 'El nombre no puede tener más de 100 caracteres.',
            'email.required'     => 'Escribe el correo electrónico.',
            'email.email'        => 'Escribe un correo electrónico válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'rol.required'       => 'Selecciona un rol.',
            'rol.in'             => 'El rol seleccionado no es válido.',
            'password.required'  => 'Escribe una contraseña.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}