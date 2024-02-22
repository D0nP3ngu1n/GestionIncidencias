<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param null no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recoger todos los id de la tabla departamento
        $departamentoId = Departamento::pluck('id')->toArray();
        //Array de las personas que vamos a introducir en la bd
        $personal = array(
            array(
                'dni' => '87654321Q',
                'nombre' => 'Manuel',
                'apellido1' => 'Llano',
                'apellido2' => 'Rebanal',
                'direccion' => 'Tonanes',
                'localidad' => 'Alfoz de Lloredo',
                'cp' => '39329',
                'tlf' => '666666666',
                'departamento_id' => $departamentoId[0],
            ),
            array(
                'dni' => '45677654Y',
                'nombre' => 'Lucia',
                'apellido1' => 'Ferreras',
                'apellido2' => 'Fernandez',
                'direccion' => 'Torres',
                'localidad' => 'Torrelavega',
                'cp' => '39300',
                'tlf' => '666666667',
                'departamento_id' => $departamentoId[0],
            ),
            array(
                'dni' => '12344321R',
                'nombre' => 'David',
                'apellido1' => 'Prado',
                'apellido2' => 'Mejuto',
                'direccion' => 'Cartes',
                'localidad' => 'Torrelavega',
                'cp' => '39300',
                'tlf' => '666666668',
                'departamento_id' => $departamentoId[1]
            ),
            array(
                'dni' => '90909090O',
                'nombre' => 'Tania',
                'apellido1' => 'Echavarria',
                'apellido2' => 'Fernandez',
                'direccion' => 'Selaya',
                'localidad' => 'Santander',
                'cp' => '39378',
                'tlf' => '666666670',
                'departamento_id' => $departamentoId[1]
            ),
            array(
                'dni' => '34566543P',
                'nombre' => 'Samuel',
                'apellido1' => 'Quintanal',
                'apellido2' => 'Verdasco',
                'direccion' => 'Polanco',
                'localidad' => 'Torrelavega',
                'cp' => '39300',
                'tlf' => '666666679',
                'departamento_id' => $departamentoId[2]
            ),
            array(
                'dni' => '87655432P',
                'nombre' => 'Hugo',
                'apellido1' => 'Cayon',
                'apellido2' => 'Laso',
                'direccion' => 'Castaneda',
                'localidad' => 'Torrelavega',
                'cp' => '39300',
                'tlf' => '666666676',
                'departamento_id' => $departamentoId[2]
            ),
            array(
                'dni' => '69696969S',
                'nombre' => 'Efren',
                'apellido1' => 'Gutierrez',
                'apellido2' => 'Cantero',
                'direccion' => 'Torrelavega',
                'localidad' => 'Torrelavega',
                'cp' => '39300',
                'tlf' => '666666673',
                'departamento_id' => $departamentoId[2]
            ),
        );
        //recorrer array de personas
        foreach ($personal as $persona) {
            //Creacion del objeto del modelo persona
            $objetoPersona = new Persona();
            $objetoPersona->dni = $persona['dni'];
            $objetoPersona->nombre = $persona['nombre'];
            $objetoPersona->apellido1 = $persona['apellido1'];
            $objetoPersona->apellido2 = $persona['apellido2'];
            $objetoPersona->direccion = $persona['direccion'];
            $objetoPersona->localidad = $persona['localidad'];
            $objetoPersona->cp = $persona['cp'];
            $objetoPersona->tlf = $persona['tlf'];
            $objetoPersona->activo = true;
            $objetoPersona->departamento_id = $persona['departamento_id'];
            //Guardar objeto persona
            $objetoPersona->save();
        }
    }
}