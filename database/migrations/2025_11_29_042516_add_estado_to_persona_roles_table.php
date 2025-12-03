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
        // For pivot tables with composite primary keys, we need to use raw SQL
        // to add a column without dropping constraints
        DB::statement('ALTER TABLE persona_roles ADD COLUMN estado VARCHAR(10) DEFAULT "Activo"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persona_roles', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
