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
     * Rellena la base de datos de la aplicacion web
     * @param null no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Borrar las tablas en orden para que no haya errores en las claves foraneas
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('comentarios')->delete();
        DB::table('incidencias')->delete();
        DB::table('users')->delete();
        DB::table('equipos')->delete();
        DB::table('aulas')->delete();
        //DB::table('incidencias_subtipos')->delete();
        DB::table('departamentos')->delete();
        //Rellenar las tablas en orden para evitar los errores de claves foraneas
        $this->call(RoleSeeder::class);
        $this->call(AulaSeeder::class);
        $this->call(EquipoSeeder::class);
        // $this->call(IncidenciaSubtipoSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(IncidenciaSeeder::class);
        $this->call(ComentarioSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
