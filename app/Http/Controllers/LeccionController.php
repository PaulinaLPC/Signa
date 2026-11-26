<?php

namespace App\Http\Controllers;

use App\Models\Leccion;
use App\Models\Progreso;
use Illuminate\Http\Request;

class LeccionController extends Controller
{
    // Porcentaje mínimo para completar una lección
    private const MINIMO_APROBATORIO = 0.6;

    // Lista de lecciones con el progreso del usuario
    public function index(Request $request)
    {
        $lecciones = Leccion::with('categoria')
            ->withCount('ejercicios')
            ->orderBy('orden')
            ->get();

        $progresos = $request->user()->progresos()->get()->keyBy('leccion_id');

        $completadas = $progresos->where('completada', true)->count();

        $porcentaje = $lecciones->count() > 0
            ? round($completadas / $lecciones->count() * 100)
            : 0;

        return view('lecciones.index', compact('lecciones', 'progresos', 'completadas', 'porcentaje'));
    }

    // Contenido de una lección y sus señas
    public function show(Request $request, Leccion $leccion)
    {
        $leccion->load('categoria')->loadCount('ejercicios');

        $senas = $leccion->categoria
            ? $leccion->categoria->senas()->with('categoria')->orderBy('id')->get()
            : collect();

        $progreso = $request->user()
            ->progresos()
            ->where('leccion_id', $leccion->id)
            ->first();

        return view('lecciones.show', compact('leccion', 'senas', 'progreso'));
    }

    // Formulario de ejercicios
    public function ejercicios(Leccion $leccion)
    {
        $ejercicios = $leccion->ejercicios()->with('sena.categoria')->get();

        abort_if($ejercicios->isEmpty(), 404, 'Esta lección todavía no tiene ejercicios.');

        return view('lecciones.ejercicios', compact('leccion', 'ejercicios'));
    }

    // Califica las respuestas y guarda el progreso
    public function calificar(Request $request, Leccion $leccion)
    {
        $ejercicios = $leccion->ejercicios()->get();

        // Todas las preguntas son obligatorias
        $reglas = [];
        foreach ($ejercicios as $ejercicio) {
            $reglas["respuestas.{$ejercicio->id}"] = ['required', 'string'];
        }

        $request->validate($reglas, [
            'respuestas.*.required' => 'Responde todas las preguntas antes de calificar.',
        ]);

        $respuestas = $request->input('respuestas', []);
        $aciertos = 0;
        $detalle = [];

        foreach ($ejercicios as $ejercicio) {
            $elegida = $respuestas[$ejercicio->id] ?? null;
            $correcta = $elegida === $ejercicio->respuesta;

            if ($correcta) {
                $aciertos++;
            }

            $detalle[] = [
                'palabra'  => $ejercicio->respuesta,
                'elegida'  => $elegida,
                'correcta' => $correcta,
            ];
        }

        $total = $ejercicios->count();
        $aprobada = $total > 0 && ($aciertos / $total) >= self::MINIMO_APROBATORIO;

        // Se guarda el mejor resultado; una lección completada no se pierde
        $progreso = Progreso::firstOrNew([
            'user_id'    => $request->user()->id,
            'leccion_id' => $leccion->id,
        ]);

        if (! $progreso->exists || $aciertos >= $progreso->aciertos) {
            $progreso->aciertos = $aciertos;
        }

        $progreso->total = $total;
        $progreso->completada = $progreso->completada || $aprobada;
        $progreso->save();

        return redirect()
            ->route('lecciones.show', $leccion->slug)
            ->with('resultado', compact('aciertos', 'total', 'aprobada', 'detalle'));
    }
}