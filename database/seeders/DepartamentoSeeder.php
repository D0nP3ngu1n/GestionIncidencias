<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->departamentos as $departamento) {
             $objetoDepartamento = new Departamento();
            $objetoDepartamento->cod = $departamento['cod'];
            $objetoDepartamento->nombre = $departamento['nombre'];
            $objetoDepartamento->activo = $departamento['activo'];
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
