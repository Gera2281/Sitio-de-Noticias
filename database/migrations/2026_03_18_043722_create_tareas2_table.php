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
        Schema::create('tareas2', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 50); 
            $table->string('descripcion', 255); 
            $table->boolean('atendido')->default(0);
            $table->date('entrega'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas2');
    }
};
