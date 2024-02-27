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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('departamento')->nullable();
            $table->foreign('departamento')->references('id')->on('departamentos');
            $table->string('guid')->nullable();
            $table->string('domain')->nullable();
            $table->string('DistinguishedName')->nullable();
            $table->string('nombre')->nullable();
            $table->string('nombre_usuario')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('departamento');
            $table->dropColumn('departamento');
        });
    }
};
