<?php

namespace Database\Seeders;

use App\Models\Comentario;
use App\Models\Incidencia;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param none no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recoger los id de la tabla users
        $personaId = User::pluck('id')->toArray();
        //Recoger los if de la tabla incidencia
        $incidenciaId = Incidencia::pluck('id')->toArray();
        //array comentarios
        $comentarios = array(
            array(
                'texto' => 'Comentario de prueba 1',
                'incidencia_id' => rand($incidenciaId[0], ($incidenciaId[0] + ($incidenciaId[count($incidenciaId) - 1] - $incidenciaId[0]))),
                'users_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
            ),
            array(
                'texto' => 'Comentario de prueba 2',
                'incidencia_id' => rand($incidenciaId[0], ($incidenciaId[0] + ($incidenciaId[count($incidenciaId) - 1] - $incidenciaId[0]))),
                'users_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
            ),
            array(
                'texto' => 'Comentario de prueba 3',
                'incidencia_id' => rand($incidenciaId[0], ($incidenciaId[0] + ($incidenciaId[count($incidenciaId) - 1] - $incidenciaId[0]))),
                'users_id' => rand($personaId[0], ($personaId[0] + ($personaId[count($personaId) - 1] - $personaId[0]))),
            ),
        );
        //Recorrer el array de comentarios
        foreach ($comentarios as $comentario) {
            //Creacion del objeto del modelo de comentarios para rellenar la BD
            $objetoComentario = new Comentario();
            $objetoComentario->texto = $comentario['texto'];
            $objetoComentario->fechahora = date('Y-m-d H:i:s');
            $objetoComentario->incidencia_id = $comentario['incidencia_id'];
            $objetoComentario->users_id = $comentario['users_id'];
            //guardar el objeto en la base de datos
            $objetoComentario->save();
        }
    }
}
