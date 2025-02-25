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
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('tipo', ['imagen', 'video']);
            $table->string('url', 255);
            $table->text('descripcion')->nullable();
            $table->foreignId('id_noticia')->constrained('news')->onDelete('cascade');
            $table->foreignId('id_fotografo')->constrained('photographers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
