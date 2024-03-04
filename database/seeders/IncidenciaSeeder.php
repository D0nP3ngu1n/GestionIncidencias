<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param none no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recoger todos los Id de la tabla incidencias_subtipo en un array
        $subtiposId = IncidenciaSubtipo::pluck('id')->toArray();
        //Recoger todos los Id de la tabla users en un array
        $personaId = User::pluck('id')->toArray();

        $equipoId = Equipo::pluck('id')->toArray();
        //Array de las incidencias que vamos a crear

        $indencias = array(
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 1',
                'estado' => 'abierta',
                'creador_id' => $personaId[0],
                'prioridad' => 'baja',
                'equipo_id' => $equipoId[0],
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 2',
                'estado' => 'en proceso',
                'creador_id' => $personaId[0],
                'prioridad' => 'media',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 3',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 4',
                'estado' => 'enviada a Infortec',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 5',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 6',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 7',
                'estado' => 'abierta',
                'creador_id' => $personaId[0],
                'prioridad' => 'baja',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 8',
                'estado' => 'en proceso',
                'creador_id' => $personaId[0],
                'prioridad' => 'media',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 9',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 10',
                'estado' => 'enviada a Infortec',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 11',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 12',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 13',
                'estado' => 'abierta',
                'creador_id' => $personaId[0],
                'prioridad' => 'baja',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 14',
                'estado' => 'en proceso',
                'creador_id' => $personaId[0],
                'prioridad' => 'media',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 15',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 16',
                'estado' => 'enviada a Infortec',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 16',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 17',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 18',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 19',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 20',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 21',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 22',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 23',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 24',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 25',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 26',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),  array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 27',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 28',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 29',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 30',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 31',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 32',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 33',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 34',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 35',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 36',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 37',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),

        );
        //recorrer el array de incidencias para cargar en la base de datos
        foreach ($indencias as $incidencia) {
            //Crear el objeto del modelo Incidencias
            $objetoIncidencia = new Incidencia();
            $objetoIncidencia->tipo = $incidencia['tipo'];
            $objetoIncidencia->subtipo_id = $incidencia['subtipo_id'];
            $objetoIncidencia->descripcion = $incidencia['descripcion'];
            $objetoIncidencia->estado = $incidencia['estado'];
            $objetoIncidencia->fecha_creacion = date('Y-m-d H:i:s');
            $objetoIncidencia->creador_id = $incidencia['creador_id'];
            $objetoIncidencia->prioridad = $incidencia['prioridad'];
            $objetoIncidencia->equipo_id = $incidencia['equipo_id'];
            //Cargar el objeto en la base de datos
            $objetoIncidencia->save();
        }
    }
}
