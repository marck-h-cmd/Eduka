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
        Schema::table('docente_especialidad', function (Blueprint $table) {
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo')->after('id_especialidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docente_especialidad', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
