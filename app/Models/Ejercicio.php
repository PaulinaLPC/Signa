<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';

    protected $fillable = [
        'leccion_id',
        'sena_id',
        'pregunta',
        'opciones',
        'respuesta',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'opciones' => 'array',
        ];
    }

    public function leccion(): BelongsTo
    {
        return $this->belongsTo(Leccion::class);
    }

    public function sena(): BelongsTo
    {
        return $this->belongsTo(Sena::class);
    }
}