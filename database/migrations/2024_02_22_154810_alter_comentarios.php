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
            $table->unsignedBigInteger('incidencia_num');
            $table->unsignedBigInteger('personal_id');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('incidencia_num')->references('num')->on('incidencias');
            $table->foreign('personal_id')->references('id')->on('personal');
        });
    }
};
