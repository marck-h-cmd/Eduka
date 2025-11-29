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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('dni', 8)->unique();
            $table->string('telefono', 15)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->text('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('estado', 10)->default('Activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
