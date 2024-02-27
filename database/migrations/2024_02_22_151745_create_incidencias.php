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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['EQUIPOS','CUENTAS','WIFI','INTERNET','SOFTWARE']);
            $table->unsignedBigInteger('subtipo_id')->nullable();
            $table->datetime('fecha_creacion');
            $table->datetime('fecha_cierre')->nullable();
            $table->text('descripcion');
            $table->enum('estado', ['abierta','asignada','en proceso','enviada a Infortec','resuelta','cerrada']);
            $table->text('adjunto_url')->nullable();
            $table->unsignedBigInteger('creador_id');
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->integer('duracion')->nullable();
            $table->unsignedBigInteger('equipo_id')->nullable();
            $table->enum('prioridad', ['alta','media','baja'])->nullable();
            $table->foreign('subtipo_id')->references('id')->on('incidencias_subtipos');
            $table->foreign('creador_id')->references('id')->on('users');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('equipo_id')->references('id')->on('equipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
