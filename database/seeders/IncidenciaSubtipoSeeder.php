<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncidenciaSubtipo;

class IncidenciaSubtipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $tiposIncidencias = array(
        "Equipos" => array(
            "PC" => array("Ratón", "Ordenador", "Teclado"),
            "Altavoces",
            "Monitor",
            "Proyector",
            "Pantalla interactiva",
            "Portátil" => array("Portátil proporcionado por Consejería", "Portátil de aula"),
            "Impresoras"
        ),
        "Cuentas" => array(
            "Educantabria",
            "Google Classroom",
            "Dominio",
            "Yedra"
        ),
        "Wifi" => array(
            "Iesmiguelherrero",
            "WIECAN"
        ),
        "Software" => array(
            "Instalación",
            "Actualización"
        )
    );


    /**
     *
     * Datos de prueba en base al array de tiposIncidencias
     * @param null no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recorrer array de tipo de incidencia
        foreach ($this->tiposIncidencias as $tipo => $subtipos) {
            //Recorrer el array de subtipos de incidencias
            foreach ($subtipos as $subtipo => $subSubtipos) {
                //Si es array, guardamos los subsubtipos que haya, en caso contrario, el subsubtipo en nulo
                if (is_array($subSubtipos)) {
                    foreach ($subSubtipos as $subSubtipo) {
                        $nuevoSubTipo = new IncidenciaSubtipo();
                        $nuevoSubTipo->tipo = $tipo;
                        $nuevoSubTipo->subtipo_nombre = $subtipo;
                        $nuevoSubTipo->sub_subtipo = $subSubtipo;
                        $nuevoSubTipo->save();
                    }
                } else {
                    $nuevoSubTipo = new IncidenciaSubtipo();
                    $nuevoSubTipo->tipo = $tipo;
                    $nuevoSubTipo->subtipo_nombre = $subSubtipos;
                    $nuevoSubTipo->sub_subtipo = null;
                    $nuevoSubTipo->save();
                }
            }
        }

        $this->command->info('Tabla subtipos inicializada con datos');

    }
}