<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personaId = Persona::pluck('id')->toArray();
        $perfiles = array(
            array(
                'personal_id' => $personaId[0],
                'dominio' => 'testProfRob1',
                'educantabria' => 'Manuel@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'profesor'
            ),
            array(
                'personal_id' => $personaId[1],
                'dominio' => 'testProfRob2',
                'educantabria' => 'Lucia@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'profesor'
            ),
            array(
                'personal_id' => $personaId[2],
                'dominio' => 'testProfArte1',
                'educantabria' => 'David@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'profesor'
            ),
            array(
                'personal_id' => $personaId[3],
                'dominio' => 'testProfArte2',
                'educantabria' => 'Tania@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'profesor'
            ),
            array(
                'personal_id' => $personaId[4],
                'dominio' => 'testProfEner1',
                'educantabria' => 'Samu@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'profesor'
            ),
            array(
                'personal_id' => $personaId[5],
                'dominio' => 'testProfEner2',
                'educantabria' => 'Hugo@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'profesor'
            ),
            array(
                'personal_id' => $personaId[6],
                'dominio' => 'AdminTic1',
                'educantabria' => 'Efren@educantabria.es',
                'password' => 'Usuario@1',
                'perfil' => 'administrador'
            ),
        );
    }
}
