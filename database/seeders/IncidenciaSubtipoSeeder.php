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
        foreach ($this->tiposIncidencias as $tipo => $subtipos) {
            foreach ($subtipos as $subtipo => $subSubtipos) {
                if (is_array($subSubtipos) && count($subSubtipos) > 0) {
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
