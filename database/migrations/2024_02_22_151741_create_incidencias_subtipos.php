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
        Schema::create('incidencias_subtipos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['EQUIPOS','CUENTAS','WIFI','INTERNET','SOFTWARE']);
            $table->string('subtipo_nombre', 20)->nullable();
            $table->string('sub_subtipo', 40)->nullable();
        });

        DB::table('incidencias_subtipos')->insert([
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PC', 'sub_subtipo' => 'ORDENADOR'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PC', 'sub_subtipo' => 'RATÓN'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PC', 'sub_subtipo' => 'TECLADO'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'ALTAVOCES', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'MONITOR', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PROYECTOR', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PANTALLA', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PORTÁTIL', 'sub_subtipo' => 'PROPORCIONADO POR CONSEJERÍA'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PORTÁTIL', 'sub_subtipo' => 'DE AULA'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'IMPRESORA', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'EDUCANTABRIA', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'GOOGLE CLASSROOM', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'DOMINIO', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'YEDRA', 'sub_subtipo' => 'GESTIONA J.EST.'],
            ['tipo' => 'WIFI', 'subtipo_nombre' => 'iesmiguelherrero', 'sub_subtipo' => NULL],
            ['tipo' => 'WIFI', 'subtipo_nombre' => 'WIECAN', 'sub_subtipo' => NULL],
            ['tipo' => 'SOFTWARE', 'subtipo_nombre' => 'INSTALACIÓN', 'sub_subtipo' => NULL],
            ['tipo' => 'SOFTWARE', 'subtipo_nombre' => 'ACTUALIZACIÓN', 'sub_subtipo' => NULL],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias_subtipos');
    }
};
