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
        Schema::table('departamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('jefedep_id')->nullable();
            $table->foreign('jefedep_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departamentos', function (Blueprint $table) {
            $table->dropForeign(['jefedep_id']);
            $table->dropColumn('jefedep_id');
        });
    }
};
