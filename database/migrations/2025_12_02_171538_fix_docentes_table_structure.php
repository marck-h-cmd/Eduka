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
        Schema::table('docentes', function (Blueprint $table) {
            // Change emailUniversidad from int to varchar
            $table->string('emailUniversidad', 100)->change();
            // Remove the single especialidad field (will use pivot table)
            $table->dropColumn('especialidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            // Add back the especialidad field
            $table->string('especialidad', 100)->nullable()->after('emailUniversidad');
            // Change emailUniversidad back to int (though this seems wrong)
            $table->integer('emailUniversidad')->change();
        });
    }
};
