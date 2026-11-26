<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leccion extends Model
{
    protected $table = 'lecciones';

    protected $fillable = [
        'categoria_id',
        'titulo',
        'slug',
        'descripcion',
        'contenido',
        'nivel',
        'orden',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ejercicios(): HasMany
    {
        return $this->hasMany(Ejercicio::class)->orderBy('orden');
    }

    public function progresos(): HasMany
    {
        return $this->hasMany(Progreso::class);
    }
}