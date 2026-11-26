<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leccion_id')
                  ->constrained('lecciones')
                  ->cascadeOnDelete();
            $table->foreignId('sena_id')
                  ->nullable()
                  ->constrained('senas')
                  ->nullOnDelete();
            $table->string('pregunta');
            $table->json('opciones');          // lista de posibles respuestas
            $table->string('respuesta');       // respuesta correcta
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};