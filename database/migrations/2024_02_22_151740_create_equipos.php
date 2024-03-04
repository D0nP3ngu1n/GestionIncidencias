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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_equipo', ['altavoces','impresora','monitor','pantalla interactiva','portátil de aula','portátil Consejería','proyector']);
            $table->date('fecha_adquisicion')->nullable();
            $table->char('etiqueta', 8);
            $table->string('marca', 20);
            $table->string('modelo', 45)->nullable();
            $table->text('descripcion')->nullable();
            $table->tinyInteger('baja')->default(0)->nullable();
            $table->unsignedBigInteger('aula_num');
            $table->integer('puesto')->nullable();
            $table->foreign('aula_num')->references('num')->on('aulas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
