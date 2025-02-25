<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_noticia')->constrained('news')->onDelete('cascade');
            $table->foreignId('id_lector')->constrained('readers')->onDelete('cascade');
            $table->text('comentario');
            $table->timestamp('fecha_comentario')->useCurrent();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coments');
    }
};
