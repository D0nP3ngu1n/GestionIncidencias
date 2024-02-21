<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comentario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.Merche
     */
    public function run(): void
    {
        DB::table('equipos')->delete();
        DB::table('aulas')->delete();
        $this->call(AulaSeeder::class);
        $this->call(EquipoSeeder::class);

        $this->call(IncidenciaSubtipoSeeder::class);
       /* DB::table('comentarios')->delete();
        DB::table('perfiles')->delete();
        DB::table('incidencias_subtipos')->delete();
        DB::table('personal')->delete();
        DB::table('departamentos')->delete();
        DB::table('incidencias')->delete();*/
        $this->call(DepartamentoSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(PerfilSeeder::class);
        $this->call(IncidenciaSeeder::class);
        $this->call(ComentarioSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
