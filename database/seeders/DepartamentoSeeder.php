<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param none no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recorrer array departamentos
        foreach ($this->departamentos as $departamento) {
            //Creacion del objeto del modelo departamento
            $objetoDepartamento = new Departamento();
            $objetoDepartamento->cod = $departamento['cod'];
            $objetoDepartamento->nombre = $departamento['nombre'];
            $objetoDepartamento->activo = $departamento['activo'];
            //Guardar el objetoDepartamento en la base de datos
            $objetoDepartamento->save();
        }
    }

    //Array de departamentos
    private $departamentos = array(
        array(
            'cod' => '123PPP',
            'nombre' => 'testRobotica',
            'activo' => true,
        ),
        array(
            'cod' => '456tAD',
            'nombre' => 'testArteDigital ',
            'activo' => true,
        ),
        array(
            'cod' => '123PPP',
            'nombre' => 'testRobotica',
            'activo' => true,
        ),
    );
}
