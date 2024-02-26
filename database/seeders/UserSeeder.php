<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Recoger todos los id de la tabla departamento
        $departamentoId = Departamento::pluck('id')->toArray();
        //Array de las personas que vamos a introducir en la bd
        $users = array(
            array(
                'nombre' => 'Manuel Llano Rebanal',
                'email' => 'Manuel@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[0],
            ),
            array(
                'nombre' => 'Lucia Ferreras Fernandez',
                'email' => 'Lucia@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[0],
            ),
            array(
                'nombre' => 'David Prado Mejuto',
                'email' => 'David@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[1]
            ),
            array(
                'nombre' => 'Tania Echavarria Fernandez',
                'email' => 'Tania@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[1]
            ),
            array(
                'nombre' => 'Samuel Quintanal Verdasco',
                'email' => 'Samuel@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[2]
            ),
            array(
                'nombre' => 'Hugo Cayon Laso',
                'email' => 'Hugo@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[2]
            ),
            array(
                'nombre' => 'Efren Gutierrez Cantero',
                'email' => 'Efren@educantabria.es',
                'password' => 'Usuario@1',
                'departamento_id' => $departamentoId[2]
            ),
        );
        //Recorrer array de users
        foreach ($users as $user) {
            //Creacion del modelo de la base de datos
            $objetoUser = new User();
            $objetoUser->nombre_completo = $user['nombre'];
            $objetoUser->email = $user['email'];
            $objetoUser->slug = Str::slug($user['nombre']);
            $objetoUser->password = Hash::make($user['password']);
            $objetoUser->departamento_id = $user['departamento_id'];
            //Guardado del objeto User
            $objetoUser->save();
        }
    }
}
