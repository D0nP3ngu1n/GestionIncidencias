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
        //
        Schema::table('comentarios', function (Blueprint $table) {
            $table->unsignedBigInteger('incidencia_id');
            $table->unsignedBigInteger('users_id');
            $table->foreign('incidencia_id')->references('id')->on('incidencias');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['incidencia_id']);
            $table->dropColumn('incidencia_id');
            $table->dropForeign(['users_id']);
            $table->dropColumn('users_id');
        });
    }
};
