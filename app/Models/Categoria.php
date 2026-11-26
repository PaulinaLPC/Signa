<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'icono',
    ];

    // Una categoría tiene muchas señas
    public function senas(): HasMany
    {
        return $this->hasMany(Sena::class);
    }
}