<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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

    /*
    |--------------------------------------------------------------------------
    | Accesores de multimedia
    |--------------------------------------------------------------------------
    | En las vistas se usan como:
    |   $sena->imagen_url   → foto (propia o miniatura de YouTube)
    |   $sena->youtube_id   → ID del video de YouTube
    |   $sena->video_url    → video que no es de YouTube (archivo o enlace .mp4)
    |   $sena->tiene_video  → true si tiene cualquier video
    */

    // ID del video si es un enlace de YouTube
    public function getYoutubeIdAttribute(): ?string
    {
        if (! $this->video) {
            return null;
        }

        preg_match(
            '~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([\w-]{11})~',
            $this->video,
            $coincidencias
        );

        return $coincidencias[1] ?? null;
    }

    // Foto: la propia, o si no hay, la miniatura del video de YouTube
    public function getImagenUrlAttribute(): ?string
    {
        if ($this->imagen) {
            return $this->rutaPublica($this->imagen);
        }

        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }

        return null;
    }

    // Video que no es de YouTube (por ejemplo, un enlace directo a .mp4)
    public function getVideoUrlAttribute(): ?string
    {
        if ($this->youtube_id) {
            return null;
        }

        return $this->rutaPublica($this->video);
    }

    // Indica si la seña tiene algún video
    public function getTieneVideoAttribute(): bool
    {
        return (bool) ($this->youtube_id || $this->video_url);
    }

    // Convierte la ruta guardada en una URL
    private function rutaPublica(?string $ruta): ?string
    {
        if (! $ruta) {
            return null;
        }

        // Enlace de internet
        if (Str::startsWith($ruta, ['http://', 'https://'])) {
            return $ruta;
        }

        // Archivo subido desde el panel de administración (Módulo 4)
        return asset('storage/' . $ruta);
    }
}