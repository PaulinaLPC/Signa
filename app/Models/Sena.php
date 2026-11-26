<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sena extends Model
{
    protected $table = 'senas';

    protected $fillable = [
        'categoria_id',
        'palabra',
        'slug',
        'descripcion',
        'imagen',
        'video',
    ];

    // Una seña pertenece a una categoría
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}