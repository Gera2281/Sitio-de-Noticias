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

        if (Schema::hasTable('tareas2')) {
            Schema::rename('tareas2', 'tareas');
        }

        if (Schema::hasTable('autor2s')) {
            Schema::rename('autor2s', 'autors');
        }
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
