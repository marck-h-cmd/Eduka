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
        Schema::create('docente_especialidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_docente');
            $table->unsignedBigInteger('id_especialidad');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');

            $table->unique(['id_docente', 'id_especialidad']);
            $table->foreign('id_docente')->references('id_docente')->on('docentes')->onDelete('cascade');
            $table->foreign('id_especialidad')->references('id_especialidad')->on('especialidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_especialidad');
    }
};
