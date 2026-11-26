<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->foreignId('leccion_id')
                  ->constrained('lecciones')
                  ->cascadeOnDelete();
            $table->unsignedInteger('aciertos')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->boolean('completada')->default(false);
            $table->timestamps();

            // Un registro de progreso por usuario y lección
            $table->unique(['user_id', 'leccion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progresos');
    }
};