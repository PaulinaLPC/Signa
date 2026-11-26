<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registro
    |--------------------------------------------------------------------------
    */

    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Escribe tu nombre.',
            'name.max'           => 'El nombre no puede tener más de 100 caracteres.',
            'email.required'     => 'Escribe tu correo electrónico.',
            'email.email'        => 'Escribe un correo electrónico válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'Escribe una contraseña.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = User::create([
            'name'     => $datos['name'],
            'email'    => $datos['email'],
            'password' => $datos['password'], // se encripta automáticamente
            'rol'      => 'estudiante',
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()
            ->route('perfil')
            ->with('exito', '¡Bienvenido a Signa! Tu cuenta se creó correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | Inicio de sesión
    |--------------------------------------------------------------------------
    */

    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function iniciarSesion(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Escribe tu correo electrónico.',
            'email.email'       => 'Escribe un correo electrónico válido.',
            'password.required' => 'Escribe tu contraseña.',
        ]);

        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('perfil'))
                ->with('exito', 'Sesión iniciada. ¡Qué gusto verte de nuevo!');
        }

        return back()
            ->withErrors(['email' => 'El correo o la contraseña son incorrectos.'])
            ->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | Cerrar sesión
    |--------------------------------------------------------------------------
    */

    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('inicio')
            ->with('exito', 'Cerraste sesión correctamente.');
    }
}