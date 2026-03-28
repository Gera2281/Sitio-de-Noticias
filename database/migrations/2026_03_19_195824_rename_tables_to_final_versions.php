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
        Schema::dropIfExists('tareas');
        Schema::dropIfExists('autors');

        Schema::rename('tareas2', 'tareas');
        Schema::rename('autor2s', 'autors');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('tareas', 'tareas2');
        Schema::rename('autors', 'autor2s');
    }
};
