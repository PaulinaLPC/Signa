<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function show(Request $request)
    {
        return view('perfil.show', [
            'usuario' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $usuario = $request->user();

        $datos = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($usuario->id)],
        ], [
            'name.required'  => 'Escribe tu nombre.',
            'email.required' => 'Escribe tu correo electrónico.',
            'email.email'    => 'Escribe un correo electrónico válido.',
            'email.unique'   => 'Este correo ya está registrado por otra persona.',
        ]);

        $usuario->update($datos);

        return back()->with('exito', 'Tus datos se actualizaron correctamente.');
    }
}