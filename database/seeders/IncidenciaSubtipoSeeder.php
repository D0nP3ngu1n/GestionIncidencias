<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenciaSubtipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipos = array(
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
                "Yedra" => "En el caso de elegir Yedra debería de salir un anuncio indicando que esa gestión la realiza Jefatura de estudios."
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


    }
}
