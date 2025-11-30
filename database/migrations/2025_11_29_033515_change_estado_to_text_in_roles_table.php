<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Cambiar el tipo de columna estado de char(1) a string(10)
            $table->string('estado', 10)->default('Activo')->change();
        });

        // Actualizar los registros existentes
        DB::table('roles')->where('estado', 'A')->update(['estado' => 'Activo']);
        DB::table('roles')->where('estado', 'I')->update(['estado' => 'Inactivo']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir los cambios
        DB::table('roles')->where('estado', 'Activo')->update(['estado' => 'A']);
        DB::table('roles')->where('estado', 'Inactivo')->update(['estado' => 'I']);

        Schema::table('roles', function (Blueprint $table) {
            $table->char('estado', 1)->default('A')->change();
        });
    }
};
