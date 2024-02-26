<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1 = Role::create(['name' => 'Profesor']) ;
        $rol2 = Role::create(['name' => 'Administrador']) ;
        $rol3 = Role::create(['name' => 'Super administrador']);

        Permission::create(['name' => 'Crear usuarios']);
        Permission::create(['name' => 'Eliminar usuarios']);
        Permission::create(['name' => 'Editar incidencias']);
        Permission::create(['name' => 'Cerrar incidencias']);
    }
}
