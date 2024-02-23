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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->char('dni', 9)->nullable();
            $table->string('nombre', 25);
            $table->string('apellido1', 25);
            $table->string('apellido2', 25)->nullable();
            $table->string('direccion', 80)->nullable();
            $table->string('localidad', 25)->nullable();
            $table->char('cp', 5)->nullable();
            $table->char('tlf', 9)->nullable();
            $table->tinyInteger('activo')->default(1);
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->foreign('departamento_id')->references('id')->on('departamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
