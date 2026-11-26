<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progreso extends Model
{
    protected $table = 'progresos';

    protected $fillable = [
        'user_id',
        'leccion_id',
        'aciertos',
        'total',
        'completada',
    ];

    protected function casts(): array
    {
        return [
            'completada' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leccion(): BelongsTo
    {
        return $this->belongsTo(Leccion::class);
    }
}