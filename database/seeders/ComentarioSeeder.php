<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\Incidencia;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param null no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recoger los id de la tabla personal
        $personaId = Persona::pluck('id')->toArray();
        //Recoger los if de la tabla incidencia
        $incidenciaId = Incidencia::pluck('num')->toArray();
        //array comentarios
        $comentarios = array(
            array(
                'texto' => 'Comentario de prueba 1',
                'incidencia_num' => rand($incidenciaId[0], ($incidenciaId[0] + ($incidenciaId[count($incidenciaId) - 1] - $incidenciaId[0]))),
                'personal_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
            ),
            array(
                'texto' => 'Comentario de prueba 2',
                'incidencia_num' => rand($incidenciaId[0], ($incidenciaId[0] + ($incidenciaId[count($incidenciaId) - 1] - $incidenciaId[0]))),
                'personal_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
            ),
            array(
                'texto' => 'Comentario de prueba 3',
                'incidencia_num' => rand($incidenciaId[0], ($incidenciaId[0] + ($incidenciaId[count($incidenciaId) - 1] - $incidenciaId[0]))),
                'personal_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
            ),
        );
        //Recorrer el array de comentarios
        foreach ($comentarios as $comentario) {
            //Creacion del objeto del modelo de comentarios para rellenar la BD
            $objetoComentario = new Comentario();
            $objetoComentario->texto = $comentario['texto'];
            $objetoComentario->fechahora = date('Y-m-d H:i:s');
            $objetoComentario->incidencia_num = $comentario['incidencia_num'];
            $objetoComentario->personal_id = $comentario['personal_id'];
            //guardar el objeto en la base de datos
            $objetoComentario->save();
        }
    }
}