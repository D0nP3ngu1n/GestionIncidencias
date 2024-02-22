<?php

namespace Database\Seeders;

use App\Models\Aula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param null no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recorrer array de aulas
        foreach ($this->aulas as $aula) {
            //Creacion del modelo de aula para rellenar la base de datos
            $aulaObjeto = new Aula();
            $aulaObjeto->num = $aula['num'];
            $aulaObjeto->codigo = $aula['codigo'];
            $aulaObjeto->descripcion = $aula['descripcion'];
            $aulaObjeto->planta = $aula['planta'];
            //Guardar el objeto en la base de datos
            $aulaObjeto->save();
        }

    }

    /*
     * Array del modelo Aulas
     */

    private $aulas = array(
        array(
            'num' => 1,
            'codigo' => 'IF01',
            'descripcion' => 'Primer aula de informatica',
            'planta' => 1
        ),
        array(
            'num' => 2,
            'codigo' => 'IF02',
            'descripcion' => 'Segundo aula de informatica',
            'planta' => 1
        ),
        array(
            'num' => 3,
            'codigo' => 'IF03',
            'descripcion' => 'Tercer aula de informatica',
            'planta' => 1
        ),
        array(
            'num' => 4,
            'codigo' => 'IF04',
            'descripcion' => 'Cuarto aula de informatica',
            'planta' => 1
        )
    );
}
