<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('senas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->cascadeOnDelete();
            $table->string('palabra', 100);
            $table->string('slug', 120)->unique();
            $table->text('descripcion')->nullable();   // cómo se realiza la seña
            $table->string('imagen')->nullable();       // ruta de la fotografía
            $table->string('video')->nullable();        // ruta o enlace del video
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('senas');
    }
};