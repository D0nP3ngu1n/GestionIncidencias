<?php

namespace Database\Seeders;

use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subtiposId = IncidenciaSubtipo::pluck('id')->toArray();
        $personaId = Persona::pluck('id')->toArray();
        $indencias = array(
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 1',
                'estado' => 'abierta',
                'creador_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
                'prioridad' => 'baja'
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 2',
                'estado' => 'en proceso',
                'creador_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1]- $personaId[0]))),
                'prioridad' => 'media'
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 3',
                'estado' => 'asignada',
                'creador_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1]- $personaId[0]))),
                'prioridad' => 'alta'
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 4',
                'estado' => 'enviada a Infortec',
                'creador_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1]- $personaId[0]))),
                'prioridad' => 'alta'
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 5',
                'estado' => 'resuelta',
                'creador_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1]- $personaId[0]))),
                'prioridad' => 'alta'
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 6',
                'estado' => 'cerrada',
                'creador_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1]- $personaId[0]))),
                'prioridad' => 'alta'
            ),
        );
        foreach ($indencias as $incidencia) {
            $objetoIncidencia = new Incidencia();
            $objetoIncidencia->tipo = $incidencia['tipo'];
            $objetoIncidencia->subtipo_id = $incidencia['subtipo_id'];
            $objetoIncidencia->descripcion = $incidencia['descripcion'];
            $objetoIncidencia->estado = $incidencia['estado'];
            $objetoIncidencia->fecha_creacion = date('Y-m-d H:i:s');
            $objetoIncidencia->creador_id = $incidencia['creador_id'];
            $objetoIncidencia->prioridad = $incidencia['prioridad'];
            $objetoIncidencia->save();
        }
    }
}
