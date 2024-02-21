<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('incidencias_subtipos')->delete();
        $this->call(IncidenciaSubtipoSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
