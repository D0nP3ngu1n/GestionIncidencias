<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\Equipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param null no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recoger todas las claves llamadas num en un array
        $equiposNum = Aula::pluck('num')->toArray();
        //Creacion del array de equipos
        $equipos = array(
            array(
                'id' => 1,
                'tipo_equipo' => 'monitor',
                'fecha_adquisicion' => strtotime('2024-01-01'),
                'etiqueta' => '123456',
                'marca' => 'asus',
                'modelo' => 'T3',
                'descripcion' => 'equipo de prueba 1',
                'baja' => null,

                'aula_num' => rand(1, count($equiposNum)),
                'puesto' => 3
            ),
            array(
                'id' => 2,
                'tipo_equipo' => 'impresora',
                'fecha_adquisicion' => strtotime('2023-04-08'),
                'etiqueta' => '456789',
                'marca' => 'Corsair',
                'modelo' => 'HT5',
                'descripcion' => 'equipo de prueba 2',
                'baja' => null,
                'aula_num' => rand(1, count($equiposNum)),
                'puesto' => 2
            ),
            array(
                'id' => 3,
                'tipo_equipo' => 'pantalla interactiva',
                'fecha_adquisicion' => strtotime('2023-07-10'),
                'etiqueta' => '789123',
                'marca' => 'Eneba',
                'modelo' => 'JGT',
                'descripcion' => 'equipo de prueba 3',
                'baja' => null,
                'aula_num' => rand(1, count($equiposNum)),
                'puesto' => 5
            ),
            array(
                'id' => 4,
                'tipo_equipo' => 'portátil de aula',
                'fecha_adquisicion' => strtotime('2023-02-11'),
                'etiqueta' => '765432',
                'marca' => 'Samsung',
                'modelo' => 'PIT',
                'descripcion' => 'equipo de prueba 4',
                'baja' => null,
                'aula_num' => rand(1, count($equiposNum)),
                'puesto' => 7
            ),
        );
        //recorrer array de equipos
        foreach ($equipos as $equipo) {
            //Creacion del objeto del modelo equipos
            $equipoObjeto = new Equipo();
            $equipoObjeto->id = $equipo['id'];
            $equipoObjeto->tipo_equipo = $equipo['tipo_equipo'];
            //Dar formato a la fecha para subirla a la BD
            $equipoObjeto->fecha_adquisicion = date('Y-m-d', $equipo['fecha_adquisicion']);
            $equipoObjeto->etiqueta = $equipo['etiqueta'];
            $equipoObjeto->marca = $equipo['marca'];
            $equipoObjeto->modelo = $equipo['modelo'];
            $equipoObjeto->descripcion = $equipo['descripcion'];
            $equipoObjeto->baja = $equipo['baja'];
            $equipoObjeto->aula_num = $equipo['aula_num'];
            $equipoObjeto->puesto = $equipo['puesto'];
            //Cargar el objeto en la base de datos
            $equipoObjeto->save();
        }
    }

}
