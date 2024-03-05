#DOCUMENTACIÓN GRUPO 3

### Índice

-[DESARROLLO DE APLICACIONES WEB ENTORNO SERVIDOR](#desarrollo-de-aplicaciones-web-en-entorno-servidor) 
    -[Migraciones y Seeders](#migraciones-y-seeders) 
    -[Modelos](#modelos) 
    -[Gestión de Incidencias](#gestion-de-incidencias) 
    -[LDAP](#ldap) 
    -[Gestion de usuarios](#gestion-de-usuarios) 
    -[Gestion de aulas](#gestion-de-aulas) 
    -[Gestion de equipos](#gestion-de-equipos) 
    -[Comentarios](#comentarios) 
    -[Request](#request) 
    -[Mail](#mail) 
    -[Exportaciones](#exportaciones) 
    -[Informes](#informes) 
-[DESARROLLO DE APLICACIONES WE ENTORNO CLIENTE](#desarrollo-de-aplicaciones-web-en-estorno-cliente) 
    -[JavaScript Puro](#javascript-puro) 
    -[Ajax para Filtrados](#filtrado-de-incidencias) 
    -[Charts](#charts)  
-[DISEÑO DE INTERFACES WEB](#diseño-de-interfaces-web) 
    -[Wireframes]() 
    -[Guia de estilos]() 
    -[Plantilla]() 
    -[Formularios](#formularios) 
    -[Mostrar informacion](#mostrar-información) 
    -[Modales](#modelos) 
    -[DESPLIEGUE DE APLICACIONES WEB](#despliegue-de-aplicaciones-web)

## DESARROLLO DE APLICACIONES WEB EN ENTORNO SERVIDOR

Para conseguir el producto esperado según el enunciado y las instrucciones, empezamos creando un proyecto en laravel, el cual será la base en la que nos apoyaremos para realizar las tareas adecuadas.

### Migraciones y seeders

Dada la base de datos proporcionada para la realización del proyecto, fue necesaria su modificación para la correcta implementación de LDAP para la autorización de usuarios. Para modificarla desde el propio proyecto, generamos las siguientes migraciones

En las migraciones se ha replicado la estructura de la base de datos para lanzarla desde laravel con comandos, además de realizar algún retoque para la funcionalidad de la aplicacion

Creación de la tabla users

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
?>
```

Creación de la tabla de password_reset_tokens

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};

?>
```

Creación de la tabla password_resets

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
?>
```

Agregar seguridad a la tabla users

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'two_factor_secret',
                'two_factor_recovery_codes',
            ], Fortify::confirmsTwoFactorAuthentication() ? [
                'two_factor_confirmed_at',
            ] : []));
        });
    }
};
?>
```

Creación tabla failed_jobs

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
?>
```

Creación de la tabla personal_access_tokens

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
?>
```

Creación de la tabla sessions

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
?>
```

Creación de tabla aulas

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->id('num');
            $table->string('codigo', 8);
            $table->string('descripcion', 100);
            $table->integer('planta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
?>
```

Creación de la tabla comentarios

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('texto');
            $table->datetime('fechahora');
            $table->text('adjunto_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
?>
```

Creación de la tabla departamentos

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('cod', 6);
            $table->string('slug');
            $table->string('nombre', 45);
            $table->tinyInteger('activo')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
?>
```

Creación de la tabla equipos con relación a la tabla aulas

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_equipo', ['altavoces','impresora','monitor','pantalla interactiva','portátil de aula','portátil Consejería','proyector']);
            $table->date('fecha_adquisicion')->nullable();
            $table->char('etiqueta', 8);
            $table->string('marca', 20);
            $table->string('modelo', 45)->nullable();
            $table->text('descripcion')->nullable();
            $table->tinyInteger('baja')->default(0)->nullable();
            $table->unsignedBigInteger('aula_num');
            $table->integer('puesto')->nullable();
            $table->foreign('aula_num')->references('num')->on('aulas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
?>
```

Cración de la tabla incidencias_subtipos con datos introducidos

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias_subtipos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['EQUIPOS','CUENTAS','WIFI','INTERNET','SOFTWARE']);
            $table->string('subtipo_nombre', 20)->nullable();
            $table->string('sub_subtipo', 40)->nullable();
        });

        DB::table('incidencias_subtipos')->insert([
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PC', 'sub_subtipo' => 'ORDENADOR'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PC', 'sub_subtipo' => 'RATÓN'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PC', 'sub_subtipo' => 'TECLADO'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'ALTAVOCES', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'MONITOR', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PROYECTOR', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PANTALLA', 'sub_subtipo' => NULL],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PORTÁTIL', 'sub_subtipo' => 'PROPORCIONADO POR CONSEJERÍA'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'PORTÁTIL', 'sub_subtipo' => 'DE AULA'],
            ['tipo' => 'EQUIPOS', 'subtipo_nombre' => 'IMPRESORA', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'EDUCANTABRIA', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'GOOGLE CLASSROOM', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'DOMINIO', 'sub_subtipo' => NULL],
            ['tipo' => 'CUENTAS', 'subtipo_nombre' => 'YEDRA', 'sub_subtipo' => 'GESTIONA J.EST.'],
            ['tipo' => 'WIFI', 'subtipo_nombre' => 'iesmiguelherrero', 'sub_subtipo' => NULL],
            ['tipo' => 'WIFI', 'subtipo_nombre' => 'WIECAN', 'sub_subtipo' => NULL],
            ['tipo' => 'SOFTWARE', 'subtipo_nombre' => 'INSTALACIÓN', 'sub_subtipo' => NULL],
            ['tipo' => 'SOFTWARE', 'subtipo_nombre' => 'ACTUALIZACIÓN', 'sub_subtipo' => NULL],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias_subtipos');
    }
};
?>
```

Creación de la tabla incidencias con enum de tipo, relaciones con tabla incidencias_subtipo, users y equipos

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['EQUIPOS','CUENTAS','WIFI','INTERNET','SOFTWARE']);
            $table->unsignedBigInteger('subtipo_id')->nullable();
            $table->datetime('fecha_creacion');
            $table->datetime('fecha_cierre')->nullable();
            $table->text('descripcion');
            $table->enum('estado', ['abierta','asignada','en proceso','enviada a Infortec','resuelta','cerrada']);
            $table->text('adjunto_url')->nullable();
            $table->unsignedBigInteger('creador_id');
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->integer('duracion')->nullable();
            $table->unsignedBigInteger('equipo_id')->nullable();
            $table->enum('prioridad', ['alta','media','baja'])->nullable();
            $table->foreign('subtipo_id')->references('id')->on('incidencias_subtipos')->onDelete('cascade');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
?>
```

Agregación de relaciones a la tabla comentarios con users e incidencia

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('comentarios', function (Blueprint $table) {
            $table->unsignedBigInteger('incidencia_id');
            $table->unsignedBigInteger('users_id');
            $table->foreign('incidencia_id')->references('id')->on('incidencias')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['incidencia_id']);
            $table->dropColumn('incidencia_id');
            $table->dropForeign(['users_id']);
            $table->dropColumn('users_id');
        });
    }
};
?>
```

Creacion de las tablas, roles, permissions, model_has_permissions, model_has_roles y role_has_permissions de la extensión spatie

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id'); // permission id
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
            $table->unsignedBigInteger($pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
            $table->unsignedBigInteger($pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
?>
```

Agregación de datos y relaciones a la tabla users con departamento

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->string('guid')->nullable();
            $table->string('domain')->nullable();
            $table->string('DistinguishedName')->nullable();
            $table->string('nombre')->nullable();
            $table->string('nombre_usuario')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('departamento_id');
            $table->dropColumn('departamento_id');
        });
    }
};
?>
```

Trigger para que el primer usuario logueado sea administrador

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::unprepared("CREATE TRIGGER after_insert_users
        AFTER INSERT ON users FOR EACH ROW
        BEGIN
            DECLARE user_count INT;

            -- Contar el número de registros en la tabla users
            SELECT COUNT(*) INTO user_count FROM users;

            IF user_count > 1 THEN
                INSERT INTO model_has_roles (model_type, model_id, role_id) VALUES ('App\\\\Models\\\\User', NEW.id, 1);
            ELSE
                INSERT INTO model_has_roles (model_type, model_id, role_id) VALUES ('App\\\\Models\\\\User', NEW.id, 2);
            END IF;

        END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `after_insert_users`');
    }
};
?>
```

Adición del campo actuaciones a incidencias

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->text('actuaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropColumn('actuaciones');
        });
    }
};
?>

```

Para cargar datos de prueba en la base de datos, utilizaremos seeders que realizaran la tarea de forma automática, proporcionando los datos necesarios para trabajar.

Se ha aplicado un seeder de los roles, aulas, departamentos, equipos e incidencias con array metidos a mano

Creación de aulas

```php
<?php

namespace Database\Seeders;

use App\Models\Aula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param none no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recorrer array de aulas
        foreach ($this->aulas as $aula) {
            //Creacion del modelo de aula para rellenar la base de datos
            $aulaObjeto = new Aula();
            $aulaObjeto->num = $aula['num'];
            $aulaObjeto->codigo = $aula['codigo'];
            $aulaObjeto->descripcion = $aula['descripcion'];
            $aulaObjeto->planta = $aula['planta'];
            //Guardar el objeto en la base de datos
            $aulaObjeto->save();
        }

    }

    /*
     * Array del modelo Aulas
     */

    private $aulas = array(
        array(
            'num' => 1,
            'codigo' => 'IF01',
            'descripcion' => 'Primer aula de informatica',
            'planta' => 1
        ),
        array(
            'num' => 2,
            'codigo' => 'IF02',
            'descripcion' => 'Segundo aula de informatica',
            'planta' => 1
        ),
        array(
            'num' => 3,
            'codigo' => 'IF03',
            'descripcion' => 'Tercer aula de informatica',
            'planta' => 1
        ),
        array(
            'num' => 4,
            'codigo' => 'IF04',
            'descripcion' => 'Cuarto aula de informatica',
            'planta' => 1
        )
    );
}

?>
```

Creación de departamentos

```php
<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


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
            $objetoDepartamento->slug = Str::slug($departamento['nombre']);
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
        array(
            'cod' => 'Earum',
            'nombre' => 'Informatica',
            'activo' => true,
        )
    );
}
?>
```

Creación de equipos

```php
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
     * @param none no recibe datos
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
?>
```

Ceación de incidencias

```php
<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param none no recibe datos
     * @return void
     */
    public function run(): void
    {
        //Recoger todos los Id de la tabla incidencias_subtipo en un array
        $subtiposId = IncidenciaSubtipo::pluck('id')->toArray();
        //Recoger todos los Id de la tabla users en un array
        $personaId = User::pluck('id')->toArray();

        $equipoId = Equipo::pluck('id')->toArray();
        //Array de las incidencias que vamos a crear

        $indencias = array(
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 1',
                'estado' => 'abierta',
                'creador_id' => $personaId[0],
                'prioridad' => 'baja',
                'equipo_id' => $equipoId[0],
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 2',
                'estado' => 'en proceso',
                'creador_id' => $personaId[0],
                'prioridad' => 'media',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 3',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 4',
                'estado' => 'enviada a Infortec',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 5',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 6',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 7',
                'estado' => 'abierta',
                'creador_id' => $personaId[0],
                'prioridad' => 'baja',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 8',
                'estado' => 'en proceso',
                'creador_id' => $personaId[0],
                'prioridad' => 'media',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 9',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 10',
                'estado' => 'enviada a Infortec',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 11',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 12',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[0],
                'descripcion' => 'incidencia de prueba 13',
                'estado' => 'abierta',
                'creador_id' => $personaId[0],
                'prioridad' => 'baja',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'cuentas',
                'subtipo_id' => $subtiposId[12],
                'descripcion' => 'incidencia de prueba 14',
                'estado' => 'en proceso',
                'creador_id' => $personaId[0],
                'prioridad' => 'media',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'Wifi',
                'subtipo_id' => $subtiposId[14],
                'descripcion' => 'incidencia de prueba 15',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[1],
                'descripcion' => 'incidencia de prueba 16',
                'estado' => 'enviada a Infortec',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[2],
                'descripcion' => 'incidencia de prueba 16',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 17',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 18',
                'estado' => 'resuelta',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 19',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 20',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 21',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 22',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 23',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 24',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 25',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 26',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),  array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 27',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 28',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 29',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 30',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 31',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 32',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 33',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 34',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 35',
                'estado' => 'asignada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 36',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),
            array(
                'tipo' => 'equipos',
                'subtipo_id' => $subtiposId[3],
                'descripcion' => 'incidencia de prueba 37',
                'estado' => 'cerrada',
                'creador_id' => $personaId[0],
                'prioridad' => 'alta',
                'equipo_id' => $equipoId[0]
            ),

        );
        //recorrer el array de incidencias para cargar en la base de datos
        foreach ($indencias as $incidencia) {
            //Crear el objeto del modelo Incidencias
            $objetoIncidencia = new Incidencia();
            $objetoIncidencia->tipo = $incidencia['tipo'];
            $objetoIncidencia->subtipo_id = $incidencia['subtipo_id'];
            $objetoIncidencia->descripcion = $incidencia['descripcion'];
            $objetoIncidencia->estado = $incidencia['estado'];
            $objetoIncidencia->fecha_creacion = date('Y-m-d H:i:s');
            $objetoIncidencia->creador_id = $incidencia['creador_id'];
            $objetoIncidencia->prioridad = $incidencia['prioridad'];
            $objetoIncidencia->equipo_id = $incidencia['equipo_id'];
            //Cargar el objeto en la base de datos
            $objetoIncidencia->save();
        }
    }
}
?>
```

Creación de los roles y permisos

```php
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

        Permission::create(['name' => 'Crear usuarios']);
        Permission::create(['name' => 'Eliminar usuarios']);
        Permission::create(['name' => 'Editar incidencias']);
        Permission::create(['name' => 'Cerrar incidencias']);
    }
}
?>
```

Estos seeder se suben procesandolos en el database seeder

```php
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
        //DB::table('users')->delete();
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
        //$this->call(UserSeeder::class);
        //$this->call(IncidenciaSeeder::class);
        //$this->call(ComentarioSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
?>
```

### Modelos

Una vez modificada la base de datos, generamos los modelos que consideramos necesarios para el funcionamiento del proyecto. Los modelos generados son los siguientes

Creación de modelo users con función obtener rol, poner rol, relación con incidencias, comentarios y departamento

```php
<?php

namespace App\Models;

// Importaciones necesarias
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use PDOException;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens, HasRoles, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, AuthenticatesWithLdap;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        // No incluyas 'password' aquí si las contraseñas se manejan completamente a través de LDAP.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password', // Puedes comentar o eliminar esta línea si las contraseñas no se almacenan localmente.
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // funcion para sacar su rol
    /**
     * @param none
     * @return string retorna una cadena con el rol que tiene el usuario
     */
    public function getRol()
    {

        $rol = DB::table('roles')
            ->where('id', function ($query) {
                $query->select('role_id')
                    ->from('model_has_roles')
                    ->where('model_id', $this->id);
            })
            ->pluck('name')
            ->first();

        return $rol;
    }

    /**
     * @param int $nuevoRol , ID del rol que quieres poner al usuario
     * @return mixed 1 si es correcto redirect si es fallo
     */
    public function setRol($nuevoRol){
        try{
            return DB::table('model_has_roles')
            ->where('model_id', $this->id)
            ->update(['role_id' => $nuevoRol]);
        }catch(PDOException $e){
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el actualizar el rol');
        }
    }

    // Métodos adicionales requeridos por LdapAuthenticatable, si es necesario.

    /**
     * Relacion uno a muchos entre persona (creador) e incidencias
     * @param null no recibe parametros
     * @return
     */
    public function incidenciasCreadas()
    {
        return $this->hasMany(Incidencia::class, 'creador_id');
    }

    /**
     * Relacion uno a muchos entre persona (responsable) e incidencias
     * @param null no recibe parametros
     * @return
     */
    public function incidenciasResponsable()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id');
    }

    /**
     * Relacion uno a muchos entre persona y comentarios
     * @param null no recibe parametros
     * @return
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'personal_id');
    }


    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }
}

```

Modelo de aula, indicando nombre de la tabla, clave primaria, nombre de ruta, relación con equipos

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $table = "aulas";

    protected $primaryKey = 'num';
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'codigo';
    }

    /**
     * Relacion uno a muchos entre aula y equipos
     * @param null no recibe parametros
     * @return
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'aula_num', 'num');
    }
}

```

Creación de modelo comentario indicando nombre de tabla, función para obtener la fecha, relación con usuarios e incidencias

```php
<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "comentarios";
    public $timestamps = false;
/**
     * Funcion para sacar el tiempo que ha pasado desde que se ha creado el comentario
     * @param none no recibe parametros
     * @return
     */
    public function getFecha(){
        $fechaFormateada = Carbon::parse($this->fechahora);
        return $fechaFormateada->diffInDays(Carbon::now());
    }


    /**
     * Relacion uno a muchos entre persona y comentarios
     * @param none no recibe parametros
     * @return
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id','id');
    }

    /**
     * Relacion uno a muchos entre incidencia y comentarios
     * @param none no recibe parametros
     * @return
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'id');
    }
}

```

Modelo departamento indicando el nombre de la tabla

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $table = "departamentos";
    public $timestamps = false;



}
```

Modelo equipo indicando nombre de la tabla, nombre de ruta, relaciones con aula e incidencia

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $table = "equipos";
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'etiqueta';
    }

    /**
     * Relacion uno a muchos entre aula y equipos
     * @param null no recibe parametros
     * @return
     */
    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_num', 'num');
    }

    /**
     * Relacion uno a muchos entre equipo e incidencias
     * @param null no recibe parametros
     * @return
     */
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'equipo_id');
    }
}

```

Modelo incidencia, indicando nombre de la tabla y relaciones con subtipo, incidencia, comentario y equipo

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidencia extends Model
{
    use HasFactory;
    protected $table = "incidencias";
    public $timestamps = false;

    // public function getRouteKey()
    // {
    //     return 'id';
    // }

    /**
     * Relacion uno a uno entre subtipo e incidendia
     * @param none no recibe parametros
     * @return
     */
    public function subtipo()
    {
        return $this->belongsTo(IncidenciaSubtipo::class, 'subtipo_id', 'id');
    }

    /**
     * Relacion uno a muchos entre persona (creador) e incidencias
     * @param none no recibe parametros
     * @return
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    /**
     * Relacion uno a muchos entre persona (responsable) e incidencias
     * @param none no recibe parametros
     * @return
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Relacion uno a muchos entre incidencia y comentarios
     * @param none no recibe parametros
     * @return
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'incidencia_id');
    }

    /**
     * Relacion uno a muchos entre equipo e incidencias
     * @param none no recibe parametros
     * @return
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }
}

```

Modelo incidencia subtipo indicando nombre de la tabla y relacion con incidencias

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenciaSubtipo extends Model
{
    use HasFactory;
    protected $table = "incidencias_subtipos";
    public $timestamps = false;

    /**
     * Relacion uno a uno entre subtipo e incidendia
     * @param null no recibe parametros
     * @return
     */
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'subtipo_id', 'id');
    }
}
```

### Gestion de Incidencias

La parte más importante del proyecto es la gestión de incidencias, por lo que empezamos creando el controlador de incidencias para poder realizar las operaciones CRUD de las mismas

El controlador de incidencias tiene los metodos del CRUD, create, destroy, index, update,show, store, descargarArchivo y filtrar

```php
<?php

namespace App\Http\Controllers;

use App\Exports\IncidenciaExport;
use App\Exports\IndenciasIndexExport;
use App\Http\Requests\CrearIncidenciaRequest;
use App\Http\Requests\EditarIncidenciaRequest;
use App\Mail\IncidenciaDeleteMail;
use App\Mail\IncidenciaMail;
use App\Mail\IncidenciaUpdateMail;
use App\Models\Aula;
use App\Models\Departamento;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDOException;

class IncidenciaController extends Controller
{

    /**
     * Devuelve la vista de todas las incidencias
     *
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function index()
    {

        //$incidencias = Incidencia::all();
        $usuarios = User::all();
        $aulas = Aula::all();

        //saco el usuario logeado actualmente
        $user = auth()->user();

        //reviso que tipo de rol tiene y dependiendo de su rol solo le dejo ver sus incidencias o las de todos
        if ($user->hasRole('Profesor')) {
            $incidencias = Incidencia::where('creador_id', $user->id)->paginate(10); // 10 registros por página
        } else {
            $incidencias = Incidencia::paginate(10); // 10 registros por página
        }
        // $incidencias = Incidencia::paginate(10); // 10 registros por página

        return view('incidencias.index', ['incidencias' => $incidencias, 'aulas' => $aulas, 'usuarios' => $usuarios]);
    }

    /**
     * Exportar excel de todas las incidencias
     *
     * @return mixed Devuelve un excel con todas las incidencias
     */


    /**
     * Metodo para filtrar las las incidencias
     * @param Request $request
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function filtrar(Request $request)
    {


        $query = Incidencia::query();

        //saco el id del usuario logeado actualmente
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            $query->where('creador_id', $user->id);
        }

        // Filtrar por cada parámetro recibido
        if ($request->has('descripcion') && $request->filled('descripcion')) {
            $query->where('descripcion', 'like', '%' . $request->input('descripcion') . '%');
        }

        if ($request->has('tipo') && $request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->input('tipo') . '%');
        }

        if ($request->has('estado') && $request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->input('estado') . '%');
        }

        if ($request->has('creador') && $request->filled('creador')) {
            $query->join('users', 'incidencias.creador_id', '=', 'users.id')
                ->where('users.nombre_completo', 'LIKE', '%' . $request->input('creador') . '%');
        }

        if ($request->has('prioridad') && $request->filled('prioridad')) {
            $query->where('prioridad', 'like', '%' . $request->input('prioridad') . '%');
        }

        if ($request->has('aula') && $request->filled('aula')) {
            $incidencias = Incidencia::join('equipos', 'equipos.id', '=', 'incidencias.equipo_id')
                ->join('aulas', 'aulas.num', '=', 'equipos.aula_num')
                ->where('aulas.num', $request->aula);
            //where('aula', '=', $request->input('aula'));
        }



        if ($request->has('desde') && $request->has('hasta') && $request->filled('desde') && $request->filled('hasta')) {
            $desde = date($request->input('desde'));
            $hasta = date($request->input('hasta'));

            $query->whereBetween('fecha_creacion', [$desde, $hasta])->get();
        }


        $usuarios = User::all();
        $aulas = Aula::all();

        $incidencias = $query->paginate(10);

        return view('incidencias.index', ['incidencias' => $incidencias, 'aulas' => $aulas, 'usuarios' => $usuarios]);
    }


    /**
     * Devuelve la vista en detalle para crear incidencia
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function show(Incidencia $incidencia)
    {
        return view('incidencias.show', ['incidencia' => $incidencia]);
    }

    /**
     * Devuelve la vista en detalle de cada incidencia
     *
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function edit(Incidencia $incidencia)
    {
        $usuarios = User::all();
        return view('incidencias.edit', ['incidencia' => $incidencia, 'usuarios' => $usuarios]);
    }

    /**
     * Devuelve la vista para crear una incidencia
     *
     * @return mixed Devuelve una vista de una incidencia concreta
     */
    public function create()
    {
        $aulas = Aula::all();
        $departamentos = Departamento::all();
        $equipos = Equipo::all();
        return view('incidencias.create', ['aulas' => $aulas, 'departamentos' => $departamentos, 'equipos' => $equipos]);
    }

    /**
     * Elimina una incidencia
     *
     * @param Incidencia $incidencia objeto Incidencia
     * @return mixed Elimina una incidencia concreta
     */
    public function destroy(Incidencia $incidencia)
    {
        try {
            //Recojo el usuario para pasar a las funciones del mail
            $usuario = User::where('id', $incidencia->creador_id)->first();
            //Recojo la incidencia antes de borrarla para pasarla al mail
            $incidenciaEliminada = $incidencia;
            $incidencia->delete();
            /*Con el usuario recogido anteriormente, en el to le indico donde envia el email,
            y en el send le mando el email configurado, pasando la vista y el usuario creador
            */
            Mail::to($usuario->email)->send(new IncidenciaDeleteMail($incidenciaEliminada, $usuario));
        } catch (PDOException $e) {
            return redirect()->route('incidencias.index')->with('error', 'Error de base de datos al borrar la incidencia ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('incidencias.index')->with('error', 'Error al borrar la incidencia ' . $e->getMessage());
        }
        return redirect()->route('incidencias.index')->with('success', 'Incidencia borrada');
    }

    /**
     * Recoge los datos de un Request personalizado y modificar el objeto de tipo Incidencia que se el introduce por parametros
     * @param Incidencia $incidencia objeto Incidencia para editar
     * @param EditarIncidenciaRequest $request Request personalizado para editar la incidencia
     * @return mixed Devuelve la vista en detalle de la incidencia editada si es correcto o devuelve la vista de de todas las incidencias con un error si ha fallado la edicion
     */
    public function update(Incidencia $incidencia, EditarIncidenciaRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar editar la incidencia falla algo poder volver atras
            DB::beginTransaction();

            //modifico la incidencia que me pasan por parametros con lo que ha traido el request
            $incidencia->descripcion = $request->descripcion;

            if ($request->has('estado') && $request->filled('estado')) {
                $incidencia->estado = $request->estado;
            }
            if ($incidencia->estado == "cerrada") {
                $incidencia->fecha_cierre = Carbon::now();
            }
            if ($request->has('prioridad') && $request->filled('prioridad')) {
                $incidencia->prioridad = $request->prioridad;
            }


            if ($request->has('responsable') && $request->filled('responsable')) {
                $incidencia->responsable_id = $request->responsable;
            }



            if ($request->has('actuaciones') && $request->filled('actuaciones')) {
                $incidencia->actuaciones = $request->actuaciones;
            }


            //si en el edit me viene un fichero adjunto elimino el anterior y subo el nuevo ademas de guardar su URL
            if ($request->hasFile('adjunto')) {

                if ($request->fichero) {
                    //elimino el fichero anterior que tiene la incidencia
                    Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));
                }

                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = $request->adjunto->store('', 'ficheros');
                $incidencia->adjunto_url = $url;
            }

            $incidencia->save();
            //Recojo el usuario para pasar a las funciones del mail
            $usuario = User::where('id', $incidencia->creador_id)->first();
            /*Con el usuario recogido anteriormente, en el to le indico donde envia el email,
            y en el send le mando el email configurado, pasando la vista y el usuario creador
            */

            DB::commit();
            Mail::to($usuario->email)->send(new IncidenciaUpdateMail($incidencia, $usuario));
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Incidencia editada');
        } catch (PDOException $e) {
            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('error', 'Error de base de datos al editar la incidencia. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('incidencias.index')->with('error', 'Error al editar la incidencia. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Recoge los datos de un Request personalizado y crea una Incidencia
     * @param crearIncidenciaRequest $request Request personalizado para crear la incidencia
     * @return mixed Devuelve la vista en detalle de la incidencia creada si es correcto o devuelve la vista de de todas las incidencias con un error si ha fallado la creacion
     * */
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear la incidencia falla algo poder volver atras
            DB::beginTransaction();
            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = "abierta";
            $incidencia->fecha_creacion = Carbon::now();


            //si el usuario logueado no tiene email asociado, se le asocia el que introduzca en el formulario
            $usuario = User::where('id', auth()->user()->id)->first();

            if ($usuario->email == null) {
                $usuario->email = $request->correo_asociado;
                $usuario->save();
            }


            //si el usuario logueado no tiene departamento asociado, se le asocia el que introduzca en el formulario
            if ($usuario->departamento_id == null) {
                $usuario->departamento_id = $request->departamento;
                $usuario->save();
            }

            //el campo Creador id viene dado por el usuario actualmente logeado
            $incidencia->creador_id = auth()->user()->id;

            //si el request recibe un subtipo, buscamos el subtipo en la tabla subtipos y añadimos el id a la incidencia
            if ($request->has('subtipo') && $request->filled('subtipo') && $request->subtipo != 'null') {
                $subtipo = $request->subtipo;
                $sub_final = IncidenciaSubtipo::where('subtipo_nombre', $subtipo)->first()->id;
                $incidencia->subtipo_id = $sub_final;
            }
            //si el reuest recibe un sub-subtipo, buscamos el subtipo con los dos datos
            if ($request->has('sub-subtipo') && $request->filled('sub-subtipo')) {
                $subtipo = $request->subtipo;
                $sub_subtipo = $request->sub_subtipo;
                $sub_final = IncidenciaSubtipo::where('subtipo_nombre', $subtipo)->where('sub_subtipo', $sub_subtipo)->first()->id;
            }


            //si el request recibe el numero de etiqueta, buscamos el equipo segun la etiqueta que nos llega y lo añadimos el id a la incidencia
            if ($request->has('numero_etiqueta') && $request->filled('numero_etiqueta') && $request->numero_etiqueta != 'null') {
                $equipo_etiqueta = $request->numero_etiqueta;
                $equipo = Equipo::where('etiqueta', $equipo_etiqueta)->firstOrFail()->id;
                $incidencia->equipo_id = $equipo;
            }

            if ($request->hasFile('adjunto')) {
                //guardo el fichero y cojo su ruta para guardarla en la URL de la incidencia
                $url = $request->adjunto->store('', 'ficheros');
                $incidencia->adjunto_url = $url;
            }

            $incidencia->save();
            /*Con el usuario recogido anteriormente, en el to le indico donde envia el email,
            y en el send le mando el email configurado, pasando la vista y el usuario
            */
            DB::commit();
            Mail::to($usuario->email)->send(new IncidenciaMail($incidencia, $usuario));
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Incidencia creada');
        } catch (PDOException $e) {

            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));
            return redirect()->route('incidencias.index')->with('error', 'Error de base de datos al crear la incidencia. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {

            DB::rollBack();
            // si no se completa la creacion borro el fichero que venia en el formulario de edicion
            Storage::disk('ficheros')->delete(substr($incidencia->adjunto_url, 16));

            return redirect()->route('incidencias.index')->with('error', 'Error al crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }

    public function descargarArchivo(Incidencia $incidencia)
    {

        if ($incidencia) {
            // Redirige a la URL del archivo para iniciar la descarga
            return Response::download('assets/ficheros/' . $incidencia->adjunto_url);
        } else {
            // Maneja el caso en el que la incidencia no se encuentre
            abort(404, 'Incidencia no encontrada');
        }
    }
}

```

Para los metodos store y update, necesitaremos recoger datos de un formulario situado en las vistas create y edit, por lo que generamos dos REQUEST personalizados para validar los datos introducidos

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear una incidencia
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|max:50',
            'departamento' => 'required|max:45',
            'tipo' => 'required|in:EQUIPOS,CUENTAS,WIFI,INTERNET,SOFTWARE',
            'descripcion' => 'required|max:256',
            'adjunto' => 'mimes:jpg,pdf,csv,rtf,doc,docx',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'departamento.required' => 'El campo departamento es obligatorio.',
            'departamento.max' => 'El campo departamento debe tener menos de 45 caracteres.',
            'tipo.required' => 'El campo tipo de incidencia es obligatorio.',
            'tipo.in' => 'Las posibles opciones de tipo de incidencia son:
             Equipos,Cuentas,Wifi,Internet,Software.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'adjunto.mimes' => 'El formato del fichero debe ser csv, jpg, rtf, pdf, doc y docx',
        ];
    }
}

```

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de actualizar una incidencia
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|max:50',
            'descripcion' => 'max:256',
            'fichero' => 'mimes:jpg,pdf,csv,rtf,doc,docx',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'fichero.mimes' => 'El formato del fichero debe ser csv, jpg, rtf, pdf, doc y docx',
        ];
    }
}
```

Para poder ver los datos, crearlos y editarlos, para el CRUD de incidencias generamos las siguientes vistas, siguendo la plantilla que se explica en el apartado de DIW.

(insertar vistas de incidencias)
![](Imagenes/creacionpagos.jpg)

### Ldap

A continuación, realizamos la gestión de usuarios, utilizando LDAP
 
1.  Instalamos la libreria LDAP Record
    ```sh
    composer require directorytree/ldaprecord-laravel
    ```
1. En el auth.php de la carpeta config
    ```
    'providers' => [
            'users' => [
                'driver' => 'ldap',
                'model' => LdapRecord\Models\ActiveDirectory\User::class,
                //le pongo la regla para solo admitir profesores
                'rules' => [App\Ldap\Rules\onlyProfesores::class],
                'scopes' => [],
                'database' => [
                    'model' => App\Models\User::class,
                    'sync_passwords' => false,
                    'sync_attributes' => [
                        'name' => 'cn',
                        'email' => 'mail',
                        'nombre_completo' => 'DisplayName',
                        'departamento_id' => 'Department',
                        'DistinguishedName' => 'DistinguishedName',
                        'nombre' => 'Name',
                        'nombre_usuario' => 'SamAccountName',
                    ],
                ],
            ],
    ```
 
1. En el fichero ldap.php de la carpeta config
    ```sh
    default' => [
                'hosts' => [env('LDAP_HOST', '127.0.0.1')],
                'username' => env('LDAP_USERNAME', 'cn=user,dc=local,dc=com'),
                'password' => env('LDAP_PASSWORD', 'secret'),
                'port' => env('LDAP_PORT', 389),
                'base_dn' => env('LDAP_BASE_DN', 'dc=local,dc=com'),
                'timeout' => env('LDAP_TIMEOUT', 5),
                'use_ssl' => env('LDAP_SSL', false),
                'use_tls' => env('LDAP_TLS', false),
                'use_sasl' => env('LDAP_SASL', false),
                'sasl_options' => [
                    // 'mech' => 'GSSAPI',
                ],
            ],
    ```
 
1. En el `.env` añadir estas lineas
    ```sh
    LDAP_LOGGING=true
    LDAP_CONNECTION=default
    LDAP_HOST=10.0.1.48
    LDAP_USERNAME="daw206@iesmhp.local"
    LDAP_PASSWORD=Acercar@53
    LDAP_PORT=389
    LDAP_BASE_DN="DC=iesmhp,DC=local"
    LDAP_TIMEOUT=5
    LDAP_SSL=false
    LDAP_TLS=false
    LDAP_SASL=false
    LDAP_OUS_PERMITIDAS='OU=AlumnosInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios'
    ```
 
1. para limitar que usuarios pueden hacer login hay que crear una `Rule` con `php artisan:ldap make:rule "nombre_de_la_regla"
    ```php
    <?php
 
    namespace App\Ldap\Rules;
 
    use Illuminate\Database\Eloquent\Model as Eloquent;
    use LdapRecord\Laravel\Auth\Rule;
    use LdapRecord\Models\Model as LdapRecord;
 
    class onlyProfesores implements Rule
    {
        /**
         * Check if the rule passes validation.
         */
        public function passes(LdapRecord $user, Eloquent $model = null): bool
        {
            // Ejemplos DN
            //CN=DAW206,OU=DAW2,OU=AlumnosInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local
            //CN=Carmen Iza Castanedo,OU=ProfesoresInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local
 
            // Obtener la base DN desde el archivo .env -> LDAP_BASE_DN
            $baseDN = env('LDAP_BASE_DN');
 
            // Obtener las OUs permitidas desde el archivo .env -> LDAP_OUS_PERMITIDAS
            $ousPermitidas = explode('|', env('LDAP_OUS_PERMITIDAS'));
 
            // Array con OUs permitidas para pruebas rápidas
            /*$ousPermitidas = [
            ];*/
 
            // Comprobar si el atributo distinguishedname contiene alguna de las OUs permitidas
            foreach ($ousPermitidas as $ouPermitida) {
                // Construir el DN completo concatenando la OU permitida con la base DN
                $dnCompleto = $ouPermitida . ',' . $baseDN;
 
                // Comprobar si el DN completo está el el distinguishedname del usuario
                if (strpos($user->getFirstAttribute('distinguishedname'), $dnCompleto ) !== false) {
                    // Puede hacer login
                    return true;
                }
            }
 
            // No puede hacer login
            return false;
        }
    }
    ```
 
1. Probar la conexion
    ```sh
    php artisan ldap:test
    ```

### Gestion de usuarios

Para la gestion de usuarios, se ha creado un CRUD del modelo users, con los metodos index, create, store, show, edit, update y destroy

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearUserRequest;
use App\Http\Requests\EditarUserRequest;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDOException;

class UserController extends Controller
{
    /**
     * Devuelve la vista de todas los usuarios
     *
     * @return mixed Devuelve una vista con todos los usuarios
     */
    public function index()
    {
        $usuarios = User::paginate(6); // 10 registros por página
        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Devuelve la vista en para crear un usuario
     *
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('usuarios.create', ['departamentos' => $departamentos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear al usuario falla algo poder volver atras
            DB::beginTransaction();
            $usuario = new User();
            $usuario->nombreCompleto = $request->nombreCompleto;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            if ($usuario->departamento_id = null) {
                $usuario->departamento_id = $request->departamento_id;
            } else {
                $usuario->departamento_id = null;
            }
            $usuario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina del usuario con un mensaje de success
            return redirect()->route('usuarios.show', ['usuario' => $usuario])->with('Success', 'usuario creado');
        } catch (PDOException $e) {
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('error', 'Error al crear el usuario. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Devuelve la vista en detalle para crear incidencia
     * @param User $usuario objeto User
     * @return mixed Devuelve la vista en detalle de una incidencia
     */
    public function show(User $usuario)
    {
        return view('usuarios.show', ['usuario' => $usuario]);
    }

    /**
     * Devuelve la vista para editar un usuario
     *
     * @return mixed Devuelve la vista para crear una incidencia
     */
    public function edit(User $usuario)
    {
        $departamentos = Departamento::all();
        return view('usuarios.edit', ['departamentos' => $departamentos, 'usuario' => $usuario]);
    }

    /**
     * Recoge los datos de un Request personalizado y modificar el objeto de tipo usuario que se el introduce por parametros
     * @param User $usuario objeto usuario para editar
     * @param EditarUserRequest $request Request personalizado para editar al usuario
     * @return mixed Devuelve la vista en detalle del usuario editado si es correcto o devuelve la vista de todos los usuarios con un error si ha fallado la edicion
     */
    public function update(EditarUserRequest $request, User $usuario)
    {
        try {
            //empiezo una transaccion por si al intentar crear al usuario falla algo poder volver atras
            DB::beginTransaction();
            $usuario->nombre_completo = $request->nombreCompleto;
            $usuario->email = $request->email;
            $usuario->departamento_id = $request->departamento_id;

            if ($request->has('rol_id')) {
                //cambio el rol al usuario
                $usuario->setRol($request->rol_id);
            }

            $usuario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina del usuario con un mensaje de success
            return redirect()->route('usuarios.show', ['usuario' => $usuario])->with('success', 'usuario actualizado');
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un usuario
     *
     * @param User $usuario objeto User
     * @return mixed Elimina un usuario concreto
     */
    public function destroy(User $usuario)
    {
        try {
            $usuario->delete();
        } catch (PDOException $e) {

            return redirect()->route('usuarios.index', ['error' => "Error al borrar el usuario " . $e->getMessage()]);
        }
        return redirect()->route('usuarios.index', ['euccess' => "usuario borrado"]);
    }
}
```

Para poder ver los datos, crearlos y editarlos, para el CRUD de users generamos las siguientes vistas, siguendo la plantilla que se explica en el apartado de DIW.

### Gestion de aulas

Para la gestion de aulas se ha creado un CRUD de aulas con los metodos index, create, store, show, edit, update y destroy

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', ['aulas' => $aulas]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aulas.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $aula = new Aula();
            //empiezo una transaccion por si al intentar editar la incidencia falla algo poder volver atras
            DB::beginTransaction();

            if ($request->has('planta') && $request->filled('planta')) {
                $aula->planta = $request->planta;
            }

            if ($request->has('descripcion') && $request->filled('descripcion')) {
                $aula->descripcion = $request->descripcion;
            }

            if ($request->has('codigo') && $request->filled('codigo')) {
                $aula->codigo = $request->codigo;
            }
            $aula->save();


            DB::commit();
            return redirect()->route('aulas.show', ['aula' => $aula])->with('success', 'aula creada');

        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error de base de datos al editar el aula. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error al editar el aula. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        return view('aulas.show', ['aula' => $aula]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {

        return view('aulas.edit', ['aula' => $aula]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        try {
            //empiezo una transaccion por si al intentar editar la incidencia falla algo poder volver atras
            DB::beginTransaction();

            if ($request->has('planta') && $request->filled('planta')) {
                $aula->planta = $request->planta;
            }

            if ($request->has('descripcion') && $request->filled('descripcion')) {
                $aula->descripcion = $request->descripcion;
            }

            if ($request->has('codigo') && $request->filled('codigo')) {
                $aula->codigo = $request->codigo;
            }
            $aula->save();


            DB::commit();
            return redirect()->route('aulas.show', ['aula' => $aula])->with('success', 'aula editada');

        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error de base de datos al editar el aula. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('error', 'Error al editar el aula. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        try {

            $aula->delete();
        } catch (PDOException $e) {
            return redirect()->route('aulas.index')->with('error', 'Error de base de datos al borrar la aula ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('aulas.index')->with('error', 'Error al borrar el aula ' . $e->getMessage());
        }
        return redirect()->route('aulas.index')->with('success', 'Aula borrada');
    }
}
```

Para poder ver los datos, crearlos y editarlos, para el CRUD de aulas generamos las siguientes vistas, siguendo la plantilla que se explica en el apartado de DIW.

### Gestion de equipos

Para la gestion de equipos se ha creado un CRUD de equipos con los metodos index, create, store, show, edit, update y destroy

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearEquipoRequest;
use App\Models\Aula;
use App\Models\Equipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class EquipoController extends Controller
{
    /**
     * Devuelve la vista de todos los equipos
     *
     * @return mixed Devuelve una vista con todos  los equipos
     */
    public function index()
    {
        $equipos = Equipo::paginate(10);
        return view('equipos.index', ['equipos' => $equipos]);
    }
    /**
     * Devuelve la vista de detalle de un equipo
     *
     * @return mixed Devuelve la vista de detalle de un equipo
     */
    public function show(Equipo $equipo)
    {
        return view('equipos.show', ['equipo' => $equipo]);
    }


    /**
     * Devuelve la vista de crear de un equipo
     *
     * @return mixed Devuelve la vista de crear de un equipo
     */
    public function create()
    {
        //cogo todas las aulas para pasarselas a la vista de crear
        $aulas = Aula::all();
        $tipos = ['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector'];
        return view('equipos.create', ['aulas' => $aulas, 'tipos' => $tipos]);
    }
    public function store(CrearEquipoRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar crear el equipo falla algo poder volver atras
            DB::beginTransaction();

            $equipo = new Equipo();

            //si el request recibe el tipo vacio, da fallo
            if ($request->has('tipo_equipo') && $request->filled('tipo_equipo') && $request->tipo_equipo != '') {
                $equipo->tipo_equipo = $request->tipo_equipo;
            }
            //si el request recibe el aula_num vacio, da fallo
            if ($request->has('aula_num') && $request->filled('aula_num') && $request->aula_num != '') {
                $equipo->aula_num = $request->aula_num;
            }

            $equipo->fecha_adquisicion = $request->fecha_adquisicion;
            $equipo->etiqueta = $request->etiqueta;
            $equipo->marca = $request->marca;
            $equipo->modelo = $request->modelo;
            $equipo->puesto = $request->puesto;
            $equipo->descripcion = $request->descripcion;

            $equipo->save();
            DB::commit();
            return redirect()->route('equipos.show', ['equipo' => $equipo])->with('success', 'Equipo creado');
        } catch (PDOException $e) {

            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al crear el Equipo. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error al crear el Equipo. Detalles: ' . $e->getMessage());
        }
    }

    public function edit(Equipo $equipo)
    {

        //cogo todas las aulas para pasarselas a la vista de crear
        $aulas = Aula::all();
        $tipos = ['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector'];

        return view('equipos.edit', ['equipo' => $equipo, 'aulas' => $aulas, 'tipos' => $tipos]);
    }

    public function update(Equipo $equipo,CrearEquipoRequest $request)
    {
        try {
            //empiezo una transaccion por si al intentar editar el equipo falla algo poder volver atras
            DB::beginTransaction();

            //si el request recibe el tipo vacio, da fallo
            if ($request->has('tipo_equipo') && $request->filled('tipo_equipo') && $request->tipo_equipo != '') {
                $equipo->tipo_equipo = $request->tipo_equipo;
            }
            //si el request recibe el aula_num vacio, da fallo
            if ($request->has('aula_num') && $request->filled('aula_num') && $request->aula_num != '') {
                $equipo->aula_num = $request->aula_num;
            }

            $equipo->fecha_adquisicion = $request->fecha_adquisicion;
            $equipo->etiqueta = $request->etiqueta;
            $equipo->marca = $request->marca;
            $equipo->modelo = $request->modelo;
            $equipo->puesto = $request->puesto;
            $equipo->descripcion = $request->descripcion;

            $equipo->save();
            DB::commit();
            return redirect()->route('equipos.show', ['equipo' => $equipo])->with('success', 'Equipo editado');
        } catch (PDOException $e) {

            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al editar el Equipo. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('equipos.index')->with('error', 'Error al editar el Equipo. Detalles: ' . $e->getMessage());
        }
    }

    public function destroy(Equipo $equipo)
    {
        try {
            $equipo->delete();
        } catch (PDOException $e) {
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al borrar el equipo ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('equipos.index')->with('error', 'Error al borrar el equipo ' . $e->getMessage());
        }
        return redirect()->route('equipos.index')->with('success', 'Equipo borrado');
    }
}
```

Para poder ver los datos, crearlos y editarlos, para el CRUD de equipos generamos las siguientes vistas, siguendo la plantilla que se explica en el apartado de DIW.

### Comentarios

Para la creación de comentarios, se ha utilizado un controlador con los metodos create, store y destroy

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearComentarioRequest;
use App\Models\Comentario;
use App\Models\Incidencia;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use LogicException;
use PDOException;

class ComentarioController extends Controller
{

    /**
     * Devuelve la vista para crear un comentario
     *
     * @return mixed Devuelve una vista de una comentario concreta
     */
    public function create(Incidencia $incidencia)
    {
        return view('comentarios.create', ['incidencia' => $incidencia]);
    }

     /**
     * Crear un comentario
     *  @param CrearComentarioRequest $request formulario que trae los datos del comentario
     *  @param Incidencia $incidencias contiene la incidencia a la que va a ir asociado el comentario
     * @return mixed Devuelve una vista de una comentario concreta
     */
    public function store(CrearComentarioRequest $request, Incidencia $incidencia)
    {

        try {
            //empiezo una transaccion por si al intentar crear el comentario falla algo poder volver atras
            DB::beginTransaction();

            //relleno los campos del comentario con lo que viene por el request
            $comentario = new Comentario();
            $comentario->texto = $request->texto;
            //la fecha actual
            $comentario->fechaHora = Carbon::now();
            $comentario->incidencia_id = $incidencia->id;
            //el usuario logeado actualmente
            $comentario->users_id = auth()->user()->id;

            $comentario->save();
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la incidencia con un mensaje de succes
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('success', 'Comentario creado');
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('error', 'Error al crear el comentario ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('incidencias.show', ['incidencia' => $incidencia])->with('error', 'Error al crear el comentario ' . $e->getMessage());
        }
    }

    /**
     * Elimina un Comentario
     *
     * @param Comentario $Comentario objeto Comentario
     *
     * @return mixed Elimina una incidencia concreta
     */
    public function destroy(Comentario $comentario)
{
    $incidencia = DB::table('incidencias')->where('id', $comentario->incidencia_id)->first();

    try {
        $comentario->delete();
    } catch (PDOException $e) {
        return redirect()->route('incidencias.index')->with('error', 'Error de base de datos al borrar el comentario '.$e->getMessage());
    } catch (LogicException $e) {
        return redirect()->route('incidencias.index')->with('error', 'Error general al borrar el comentario '.$e->getMessage());
    }

    return redirect()->route('incidencias.show', ['incidencia' => $incidencia->id])->with('success', 'Comentario borrado');
}

}

```

Para poder ver los datos y crearlos , para el controlador de comentarios generamos las siguientes vistas, siguendo la plantilla que se explica en el apartado de DIW.

### Request

Los request se utilizan para validar los datos de envio de un formulario

Request de crear incidencia

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear una incidencia
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|max:50',
            'departamento' => 'required|max:45',
            'tipo' => 'required|in:EQUIPOS,CUENTAS,WIFI,INTERNET,SOFTWARE',
            'descripcion' => 'required|max:256',
            'adjunto' => 'mimes:jpg,pdf,csv,rtf,doc,docx',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'departamento.required' => 'El campo departamento es obligatorio.',
            'departamento.max' => 'El campo departamento debe tener menos de 45 caracteres.',
            'tipo.required' => 'El campo tipo de incidencia es obligatorio.',
            'tipo.in' => 'Las posibles opciones de tipo de incidencia son:
             Equipos,Cuentas,Wifi,Internet,Software.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'adjunto.mimes' => 'El formato del fichero debe ser csv, jpg, rtf, pdf, doc y docx',
        ];
    }
}
```

Request para actualizar una incidencia

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarIncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de actualizar una incidencia
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|max:50',
            'descripcion' => 'max:256',
            'fichero' => 'mimes:jpg,pdf,csv,rtf,doc,docx',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre debe tener menos de 25 caracteres.',
            'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
            'fichero.mimes' => 'El formato del fichero debe ser csv, jpg, rtf, pdf, doc y docx',
        ];
    }
}

```

Request para crear equipo

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion a la hora de crear un equipo
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_equipo' => 'required|in:altavoces,impresora,monitor,pantalla interactiva,portátil de aula,portátil Consejería,proyector',
            'fecha_adquisicion' => 'required',
            'etiqueta' => 'required|max:8',
            'marca' => 'required|max:20',
            'modelo' => 'required|max:45',
            'aula_num' => 'required',
            'puesto' => 'required',
            'descripcion' => 'required|max:256',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     public function messages(): array
     {
         return [
             'tipo_equipo.required' => 'El campo tipo es obligatorio.',
             'descripcion.required' => 'El campo descripcion es obligatorio.',
             'tipo_equipo.in' => 'Las posibles opciones de tipo de incidencia son:
             altavoces,impresora,monitor,pantalla interactiva,portátil de aula,portátil Consejería,proyector.',
             'descripcion.max' => 'El campo descripcion debe tener menos de 256 caracteres.',
             'puesto.required' => 'El campo puesto es obligatorio.',
             'aula_num.required' => 'El campo aula es obligatorio.',
             'marca.required' => 'El campo marca es obligatorio.',
             'modelo.required' => 'El campo modelo es obligatorio.',
             'etiqueta.required' => 'El campo etiqueta es obligatorio.',
             'fecha_adquisicion.required' => 'El campo fecha es obligatorio.',

         ];
     }
}

```

Request para editar un usuario

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombreCompleto' => 'required',
            'email' => 'required|email|ends_with:@educantabria.es',
        ];
    }

    /**
     * Mensajes de las reglas de validacion
     * @param none no recibe nada
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return [
            'nombreCompleto.required' => 'El campo nombre es obligatorio.',
            'email.ends_with' => 'El campo email debe acabar con @educantabria.es.',
            'email.required' => 'El campo email es obligatorio.',
        ];
    }
}

```

### Mail

Para la utilización de los mail, se han creado mails, que estan ubicados en la carpeta de app, uno para cuando se borra una incidencia, otra para cuando se crea una incidencia y uno mas para cuando se actualiza, con un constructor le indicas la información que va a entrar, que en este caso es el usuario y la incidencia, y con el envelope le indicas el asunto

Creación de mail que se envia al borrar una incidencia

```php
<?php

namespace App\Mail;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidenciaDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @params $incidencia Objeto modelo Incidencia, $user objeto modelo User
     * @return none
     */
    public $incidencia;
    public $user;
    public function __construct(Incidencia $incidencia, User $user)
    {
        $this->incidencia = $incidencia;
        $this->user = $user;
    }

    /**
     * Asunto del correo
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incidencia Cerrada',
        );
    }

    /**
     * Get the message content definition.
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.correoEliminacion',
            with: ['incidencia' => $this->incidencia, 'usuario' => $this->user],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

?>
```

Creación de mail enviado a la hora de crear una incidencia

```php
<?php

namespace App\Mail;

use App\Models\Incidencia;
use App\Models\User;
use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidenciaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @params $incidencia Objeto modelo Incidencia, $user objeto modelo User
     * @return none
     */
    public $incidencia;
    public $user;
    public function __construct(Incidencia $incidencia, User $user)
    {
        $this->incidencia = $incidencia;
        $this->user = $user;
    }

    /**
     * Asunto del correo
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incidencia Creada',
        );
    }

    /**
     * Get the message content definition.
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.correoCreacion',
            with: ['incidencia' => $this->incidencia, 'usuario' => $this->user],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
?>
```

Definición de mail a la hora de actualizarse

```php
<?php

namespace App\Mail;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidenciaUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @params $incidencia Objeto modelo Incidencia, $user objeto modelo User
     * @return none
     */
    public $incidencia;
    public $user;
    public function __construct(Incidencia $incidencia, User $user)
    {
        $this->incidencia = $incidencia;
        $this->user = $user;
    }

    /**
     * Asunto del correo
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incidencia Actualizada',
        );
    }

    /**
     * Get the message content definition.
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.correoActualizacion',
            with: ['incidencia' => $this->incidencia, 'usuario' => $this->user],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
?>

```

estos datos se procesan en una vista, que no hace falta añadir al web.php, y este será el contenido del correo

Vista mensaje de actualización

```php
//Vista actualización
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencia Actualizada</title>
</head>

<body>
    <h1>Incidencia Actualizada</h1>
    <p>
        Se ha actualizado la incidencia con los siguientes detalles:
    </p>
    <ul>
        <li>ID: {{ $incidencia->id }}</li>
        <li>Tipo de la incidencia: {{ $incidencia->tipo }}</li>
        <li>Estado de la incidencia: {{ $incidencia->estado }}</li>
        <li>Descripción: {{ $incidencia->descripcion }}</li>
        <li>Usuario: {{ $usuario->nombre_completo }}</li>
        <li>Fecha de creación: {{ $incidencia->fecha_creacion }}</li>
    </ul>

</body>

</html>
```

Vista de mensaje de creación

```php
//Vista creacion
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencia Creada</title>
</head>
<body>
    <h1>Incidencia Creada</h1>

    <p>
        Se ha creado una nueva incidencia con los siguientes detalles:
    </p>

    <ul>
        <li>ID: {{ $incidencia->id }}</li>
        <li>Tipo de la incidencia: {{ $incidencia->tipo }}</li>
        <li>Estado de la incidencia: {{ $incidencia->estado }}</li>
        <li>Descripción: {{ $incidencia->descripcion }}</li>
        <li>Usuario: {{ $usuario->nombre_completo }}</li>
        <li>Fecha de creación: {{ $incidencia->fecha_creacion }}</li>
    </ul>

</body>
</html>
```

Vista de eliminación

```php
//Vista eliminación
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencia Actualizada</title>
</head>

<body>
    <h1>Incidencia Eliminada</h1>
    <p>
        Se ha eliminado la incidencia con los siguientes detalles:
    </p>
    <ul>
        <li>ID: {{ $incidencia->id }}</li>
        <li>Tipo de la incidencia: {{ $incidencia->tipo }}</li>
        <li>Estado de la incidencia: {{ $incidencia->estado }}</li>
        <li>Descripción: {{ $incidencia->descripcion }}</li>
        <li>Usuario: {{ $usuario->nombre_completo }}</li>
        <li>Fecha de creación: {{ $incidencia->fecha_creacion }}</li>
    </ul>

</body>

</html>

```

Luego en los metodos de los controladores, cogiendo el usuario y la incidencia podremos poner las siguientes lineas de código

```php
//Para el store
 Mail::to($usuario->email)->send(new IncidenciaMail($incidencia, $usuario));
//Para el update
Mail::to($usuario->email)->send(new IncidenciaUpdateMail($incidencia, $usuario));
//Para el delete
Mail::to($usuario->email)->send(new IncidenciaDeleteMail($incidenciaEliminada, $usuario));
```

### Exportaciones

Las exportaciones, funcionan a través de exports, que recogen la información, para aplicar en el formulario los filtros se recogen a traves de un input hidden, y se envian en un json para que los procese

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncidenciaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $incidencias;

    public function __construct($incidencias = null)
    {
        $this->incidencias = $incidencias;
    }

    /**
     * @return Si recibe una incidencia, la devuelve
     * @return Sino, extrae los datos del array data, del json y devuelve la coleccion de incidencias filtradas recibidas
     */
    public function collection()
    {
        //dd($this->incidencias);

        if ($this->incidencias instanceof Incidencia) {
            return collect([$this->incidencias]);
        } else {
            $this->incidencias = $this->incidencias->data;  //array de las incidencias filtradas
            return collect($this->incidencias);
        }
    }

    /**
     * @return Cabecera para las exportaciones json y excel
     */
    public function headings(): array
    {
        return [
            'ID Incidencia',
            'Tipo',
            'ID Subtipo',
            'Fecha de creacion',
            'Fecha de cierre',
            'Descripcion',
            'Estado',
            'Url Adjunto',
            'ID Creador',
            'ID Responsable',
            'Duracion',
            'ID Equipo',
            'Prioridad'

        ];
    }
}
```

El controlador ExportController utiliza este fichero para procesar la información de entrada y devolver una o varias incidencias

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Exports\informeExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\IncidenciaExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Muestra todas las incidencias creadas
     *  @param null
     * @return mixed Devuelve una vista de todas las incidencias
     */
    public function index()
    {
        $incidencias = Incidencia::all();
        return view('exports.index', ['incidencias' => $incidencias]);
    }

    /**
     * Exportar las incidencias filtradas a excel
     * @param Request $request formulario que trae los datos del filtrado
     * @return mixed Descarga el fichero excel
     * Recibe la variable $incidencias (ya filtradas) del incidencias.index, las convierte en formato json y exporta el excel
     */
    public function export(Request $request)
    {
        $incidencias = json_decode($request->input('incidencias'));

        // Realizar la exportación de las incidencias filtradas
        return Excel::download(new IncidenciaExport($incidencias), 'incidencias.xlsx');
    }

    /**
     * Exportar las incidencias filtradas a pdf
     * @param Request $request formulario que trae los datos del filtrado
     * @return mixed Descarga el fichero pdf
     * Recibe la variable $incidencias (ya filtradas) del incidencias.index, las convierte en formato json,
     * carga la relacion creador y exporta el pdf
     */
    public function exportpdf(Request $request)
    {
        $data = json_decode($request->input('incidencias'));

        // Obtener los datos de las incidencias
        $incidencias = collect($data->data);    //las incidencias se encuentran dentro del array data cuando se convierte en json

        // Cargar la relación "creador" para cada incidencia
        foreach ($incidencias as $incidencia) {
            $incidencia->creador = User::find($incidencia->creador_id);
        }

        // Cargar la vista con los datos de las incidencias
        $pdf = Pdf::loadView('exports.pdf', ['incidencias' => $incidencias]);
        return $pdf->download('incidencias.pdf');
    }

    /**
     * Exportar las incidencias filtradas a csv
     * @param Request $request formulario que trae los datos del filtrado
     * @return mixed Descarga el fichero csv
     * Recibe la variable $incidencias (ya filtradas) del incidencias.index, las convierte en formato json y exporta el csv
     */
    public function exportcsv(Request $request)
    {
        $incidencias = json_decode($request->input('incidencias'));

        return Excel::download(new IncidenciaExport($incidencias), 'incidencias.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Muestra la incidencias seleccionada
     * @param null
     * @return mixed Devuelve una vista de la incidencia
     */
    public function show(Incidencia $incidencia)
    {
        return view('exports.show', ['incidencia' => $incidencia]);
    }

    /**
     * Exportar la incidencia a excel
     * @param Incidencia $incidencia recibe la incidencia seleccionada
     * @return mixed Descarga el fichero excel
     * Recibe la incidencia y exporta un excel de dicha incidencia
     */
    public function exportInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.xlsx');
    }

    /**
     * Exportar la incidencia a pdf
     * @param Incidencia $incidencia recibe la incidencia seleccionada
     * @return mixed Descarga el fichero pdf
     * Recibe la incidencia y exporta un pdf de dicha incidencia
     */
    public function exportpdfInc(Incidencia $incidencia)
    {
        //return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

        $pdf = PDF::loadView('exports.showpdf', ['incidencia' => $incidencia]);
        return $pdf->download('incidencia_' . $incidencia->id . '.pdf');
    }

    /**
     * Exportar la incidencia a csv
     * @param Incidencia $incidencia recibe la incidencia seleccionada
     * @return mixed Descarga el fichero csv
     * Recibe la incidencia y exporta un csv de dicha incidencia
     */
    public function exportcsvInc(Incidencia $incidencia)
    {
        return Excel::download(new IncidenciaExport($incidencia), 'incidencia_' . $incidencia->id . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}
```

Recoge los datos del siguiente formulario gracias al script de abajo

```php
<form id="exportForm" action="{{ route('exports.export') }}" method="POST" class="form">
                @csrf
                <input type="hidden" name="incidencias" value="{{ json_encode($incidencias) }}">
                <label for="exportOption">Exportar como:</label>
                <select id="exportOption" name="exportOption" class="form-select" aria-label="Default select example">
                    <option value="">--Elija una opción--</option>
                    <option value="{{ route('exports.export') }}">Excel</option>
                    <option value="{{ route('exports.pdf') }}">PDF</option>
                    <option value="{{ route('exports.csv') }}">CSV</option>
                </select>
            </form>

            <script>
                document.getElementById('exportOption').addEventListener('change', function() {
                    if (this.value !== '') {
                        document.getElementById('exportForm').action = this.value;
                        document.getElementById('exportForm').submit();
                    }
                });
            </script>
```

Esto se procesa gracias a las rutas puestas en el archivo de rutas web.php

```php
Route::get('exports', [ExportController::class, 'index'])->name('exports.index')->middleware('auth', 'role:Administrador');
Route::get('exports/{incidencia}', [ExportController::class, 'show'])->name('exports.show')->middleware('auth', 'role:Administrador');

Route::post('exports', [ExportController::class, 'export'])->name('exports.export')->middleware('auth', 'role:Administrador');
Route::post('exports/pdf', [ExportController::class, 'exportpdf'])->name('exports.pdf')->middleware('auth', 'role:Administrador');
Route::post('exports/csv', [ExportController::class, 'exportcsv'])->name('exports.csv')->middleware('auth', 'role:Administrador');

Route::post('exports/{incidencia}', [ExportController::class, 'exportInc'])->name('exports.exportInc')->middleware('auth', 'role:Administrador');
Route::post('exports/{incidencia}/pdf', [ExportController::class, 'exportpdfInc'])->name('exports.exportpdfInc')->middleware('auth', 'role:Administrador');
Route::post('exports/{incidencia}/csv', [ExportController::class, 'exportcsvInc'])->name('exports.exportcsvInc')->middleware('auth', 'role:Administrador');

```

Saca los datos de pdf con las siguientes vistas dependiendo de las incidencias que reciba

```php
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Incidencias</title>
</head>

<body>
    <div>
        <table id="tablaIncidencias" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Aula</th>
                    <th scope="col">Creado por</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Prioridad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidencias as $incidencia)
                    <tr class="align-middle" scope="row">
                        <td class="text-truncate">{{ $incidencia->id }}</td>
                        <td class="text-truncate">{{ $incidencia->fecha_creacion }}</td>
                        <td class="text-truncate" style="max-width: 150px;">{{ $incidencia->descripcion }}</td>
                        <td class="text-truncate">{{ $incidencia->tipo }}</td>
                        <td class="text-truncate">
                            @empty($incidencia->equipo)
                                Sin aula
                            @else
                                {{ $incidencia->equipo->aula->codigo ?? '' }}
                            @endempty
                        </td>
                        <td class="text-truncate">{{ $incidencia->creador->nombre_completo }}</td>
                        <td class="text-truncate">
                            @empty($incidencia->responsable_id)
                                Todavía no asignado
                            @else
                                {{ $incidencia->responsable_id }}
                            @endempty
                        </td>
                        <td class="text-truncate">{{ $incidencia->estado }}</td>
                        <td class="text-truncate">
                            @empty($incidencia->prioridad)
                                Todavía no asignado
                            @else
                                {{ $incidencia->prioridad }}
                            @endempty
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Incidencias</title>
</head>

<body>
    <div>
        <table id="tablaIncidencias" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Aula</th>
                    <th scope="col">Creado por</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Prioridad</th>
                </tr>
            </thead>
            <tbody>
                <tr class="align-middle" scope="row">
                    <td class="text-truncate">{{ $incidencia->id }}</td>
                    <td class=" text-truncate">{{ $incidencia->fecha_creacion }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $incidencia->descripcion }}</td>
                    <td class=" text-truncate">{{ $incidencia->tipo }}</td>
                    @if ($incidencia->equipo!=null)
                    <td class=" text-truncate">{{ $incidencia->equipo->aula->codigo }}</td>
                    @else
                    <td class=" text-truncate"></td>
                    @endif

                    <td class=" text-truncate">{{ $incidencia->creador->nombre_completo }}</td>
                    <td class=" text-truncate">
                        @empty($incidencia->responsable_id)
                            Todavía no asignado
                        @else
                            {{ $incidencia->responsable_id }}
                        @endempty
                    </td>
                    <td class=" text-truncate">{{ $incidencia->estado }}</td>
                    <td class="text-truncate">{{ $incidencia->prioridad }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

```

### Informes

Para la realización de los informes se han realizado varios exports, que sirven para recoger la informacion
del modelo del cual queremos sacar la información, aqui todos los export realizados

Informe de tipos de incidencias

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EstadisticasEstadoExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de las estadisticas segun el estado.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $estadisticas = Incidencia::select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')
            ->get();

        return view('exports.estadisticas', ['estadisticas' => $estadisticas]);
    }
}
?>
```

Exportación de todas las incidencias

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncidenciasIndexExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('incidencias.index', [
            'incidencias' => Incidencia::all()
        ]);
    }
}

?>
```

Informe de incidencias abiertas por un usuario

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InformeAbiertasExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de las incidencias abiertas.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $incidencias = Incidencia::where('estado', 'abierta')
            ->whereNotNull('creador_id')
            ->orderBy('creador_id')->get();
        return view('exports.resueltas', ['incidencias' => $incidencias]);
    }
}

?>
```

Informe de incidencias resueltas por un administrador

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InformeExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de incidencias resueltas.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $incidencias = Incidencia::where('estado', 'resuelta')
            ->whereNotNull('responsable_id')
            ->orderBy('responsable_id')
            ->get();

        return view('exports.resueltas', ['incidencias' => $incidencias]);
    }
}
?>
```

Informe de incidencias asignadas a un administrador

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ListaAdminExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de las incidencias asignadas a un administrador.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $incidencias = Incidencia::whereNotNull('responsable_id')
            ->orderBy('responsable_id')
            ->get();
        return view('exports.listaAdmin', ['incidencias' => $incidencias]);
    }
}

?>
```

Informe para ver el tiempo dedicado a cada incidencia

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TiempoDedicadoExport implements FromView, ShouldAutoSize
{

    /**
     * Método para generar la vista de exportación de las incidencias resueltas y el tiempo que llevaron.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $estadisticas = Incidencia::where('estado', 'resuelta')
            ->get();
        return view('exports.tiempoDedicado', ['estadisticas' => $estadisticas]);
    }
}
?>
```

Creación de informe segun el tiempo dedicado a cada tipo de incidencia

```php
<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TiempoResolucionPorTipoExport implements FromView, ShouldAutoSize
{
    /**
     * Método para generar la vista de exportación de las incidencias resueltas y el tiempo que llevaron.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $estadisticas = Incidencia::where('estado', 'resuelta')
            ->orderBy('tipo')
            ->get();
        return view('exports.tiempoDedicado', ['estadisticas' => $estadisticas]);
    }
}

?>
```

Todas estas exportaciones, envian datos a una vista, que los procesa para marcar la información que saldrá en
las descargas

```php
//Vista estadisticas
<div>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estadisticas as $estadistica)
                <tr>
                    <td>{{ $estadistica->tipo }}</td>
                    <td>{{ $estadistica->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

//Vista de listados de admin
<div>
    <table>
        @foreach ($incidencias as $incidencia)
            <tr>
                <td>{{ $incidencia->id }}</td>
                <td>{{ $incidencia->tipo }}</td>
                <td>{{ $incidencia->fecha_creacion }}</td>
                <td>{{ $incidencia->fecha_cierre }}</td>
                <td>{{ $incidencia->descripcion }}</td>
                <td>{{ $incidencia->estado }}</td>
                <td>{{ $incidencia->creador->nombre_completo }}</td>
                @if ($incidencia->responsable && $incidencia->responsable->nombre_completo)
                    <td>{{ $incidencia->responsable->nombre_completo }}</td>
                @else
                    <td>No asignado</td>
                @endif
                @if ($incidencia->duracion != null)
                    <td>{{ $incidencia->duracion }}</td>
                @else
                    <td>No acabado</td>
                @endif
                <td>{{ $incidencia->prioridad }}</td>
            </tr>
        @endforeach
    </table>
</div>

//Vista para procesar las resueltas

<div>
    <table>
        @foreach ($incidencias as $incidencia)
            <tr>
                <td>{{ $incidencia->id }}</td>
                <td>{{ $incidencia->tipo }}</td>
                <td>{{ $incidencia->subtipo_id }}</td>
                <td>{{ $incidencia->fecha_creacion }}</td>
                <td>{{ $incidencia->fecha_cierre }}</td>
                <td>{{ $incidencia->descripcion }}</td>
                <td>{{ $incidencia->estado }}</td>
                <td>{{ $incidencia->creador->nombre_completo }}</td>
                @if ($incidencia->responsable && $incidencia->responsable->nombre_completo)
                    <td>{{ $incidencia->responsable->nombre_completo }}</td>
                @else
                    <td>No asignado</td>
                @endif
                <td>{{ $incidencia->duracion }}</td>
                <td>{{ $incidencia->prioridad }}</td>
            </tr>
        @endforeach
    </table>
</div>

//Vista para procesar por tiempo dedicado
<div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Duracion</th>
                <th>Creador</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estadisticas as $estadistica)
                <tr>
                    <td>{{ $estadistica->id }}</td>
                    <td>{{ $estadistica->tipo }}</td>
                    <td>{{ $estadistica->duracion }}</td>
                    <td>{{ $estadistica->creador->nombre_completo }}</td>
                    @if ($estadistica->responsable && $estadistica->responsable->nombre_completo)
                        <td>{{ $estadistica->responsable->nombre_completo }}</td>
                    @else
                        <td>No asignado</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

Para descargar esto, hay un controlador de export, que crea metodos apuntando al export, con un excel::download
e indicando el formato en el que se quiere descargar, por defecto es excel

```php
<?php

namespace App\Http\Controllers;

use App\Exports\EstadisticasEstadoExport;
use App\Exports\InformeAbiertasExport;
use App\Exports\informeExport;
use App\Exports\ListaAdminExport;
use App\Exports\ListadasAdmin;
use App\Exports\TiempoDedicadoExport;
use App\Exports\TiempoResolucionPorTipoExport;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class InformeController extends Controller
{
    /**
     * Genera un informe en formato Excel con las incidencias resueltas, agrupadas por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeResueltasPorAdmin()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.xlsx');
    }

    /**
     * Genera un informe en formato CSV con las incidencias resueltas, agrupadas por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeResueltasPorAdminCsv()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con las incidencias resueltas, agrupadas por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeResueltasPorAdminPdf()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con las incidencias abiertas por cada usuario.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeAbiertasPorUsuario()
    {
        return Excel::download(new InformeAbiertasExport(), 'informe_abiertas_usuario.xlsx');
    }

    /**
     * Genera un informe en formato CSV con las incidencias abiertas por cada usuario.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeAbiertasPorUsuarioCsv(Request $request)
    {
        return Excel::download(new InformeAbiertasExport(), 'informe_abiertas_usuario.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con las incidencias abiertas por cada usuario.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeAbiertasPorUsuarioPdf()
    {

        return Excel::download(new InformeAbiertasExport(), 'informe_abiertas_usuario.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con estadísticas sobre los tipos de incidencias.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeEstadisticasTipos()
    {

        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.xlsx');
    }

    /**
     * Genera un informe en formato CSV con estadísticas sobre los tipos de incidencias.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeEstadisticasTiposCsv()
    {
        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con estadísticas sobre los tipos de incidencias.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeEstadisticasTiposPdf()
    {
        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con el tiempo dedicado a cada incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeTiempoDedicadoPorIncidencia()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.xlsx');
    }


    /**
     * Genera un informe en formato CSV con el tiempo dedicado a cada incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeTiempoDedicadoPorIncidenciaCsv()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con el tiempo dedicado a cada incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    /**
     * Genera un informe en formato Excel con los tiempos de resolución por tipo de incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiemposResolucionPorTipo()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.xslx');
    }

    /**
     * Genera un informe en formato CSV con los tiempos de resolución por tipo de incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiemposResolucionPorTipoCsv()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con los tiempos de resolución por tipo de incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiemposResolucionPorTipoPdf()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con el tiempo dedicado a cada incidencia por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiempoDedicadoEIncidenciasPorAdministrador()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.xslx');
    }

    /**
     * Genera un informe en formato CSV con el tiempo dedicado a cada incidencia por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiempoDedicadoEIncidenciasPorAdministradorCsv()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con el tiempo dedicado a cada incidencia por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiempoDedicadoEIncidenciasPorAdministradorPdf()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
```

Todo esto se procesa gracias a las rutas puestas en el archivo de rutas web.php

``` php
Route::prefix('/exports/informe')->group(function () {
    Route::get('/resueltas-admin', [InformeController::class, 'informeResueltasPorAdmin'])->name('export.informe.resueltas.admin');
    Route::get('/resueltas-admin/pdf', [InformeController::class, 'informeResueltasPorAdminPdf'])->name('export.informe.resueltas.admin.Pdf');
    Route::get('/resueltas-admin/csv', [InformeController::class, 'informeResueltasPorAdminCsv'])->name('export.informe.resueltas.admin.Csv');

    Route::get('/abiertas-usuario', [InformeController::class, 'informeAbiertasPorUsuario'])->name('export.informe.abiertas.usuario');
    Route::get('/abiertas-usuario/csv', [InformeController::class, 'informeAbiertasPorUsuarioCsv'])->name('export.informe.abiertas.usuario.Csv');
    Route::get('/abiertas-usuario/pdf', [InformeController::class, 'informeAbiertasPorUsuarioPdf'])->name('export.informe.abiertas.usuario.Pdf');

    Route::get('/estadisticas-tipos', [InformeController::class, 'informeEstadisticasTipos'])->name('export.informe.estadisticas.tipos');
    Route::get('/estadisticas-tipos/csv', [InformeController::class, 'informeEstadisticasTiposCsv'])->name('export.informe.estadisticas.tipos.Csv');
    Route::get('/estadisticas-tipos/pdf', [InformeController::class, 'informeEstadisticasTiposPdf'])->name('export.informe.estadisticas.tipos.Pdf');

    Route::get('/tiempo-dedicado', [InformeController::class, 'informeTiempoDedicadoPorIncidencia'])->name('export.informe.tiempo.dedicado');
    Route::get('/tiempo-dedicado/csv', [InformeController::class, 'informeTiempoDedicadoPorIncidenciaCsv'])->name('export.informe.tiempo.dedicado.Csv');
    Route::get('/tiempo-dedicado/pdf', [InformeController::class, 'informeTiempoDedicadoPorIncidenciaPdf'])->name('export.informe.tiempo.dedicado.Pdf');

    Route::get('/tiempos-resolucion-tipo', [InformeController::class, 'informeTiemposResolucionPorTipo'])->name('export.informe.tiempos.resolucion.tipo');
    Route::get('/tiempos-resolucion-tipo/csv', [InformeController::class, 'informeTiemposResolucionPorTipoCsv'])->name('export.informe.tiempos.resolucion.tipo.Csv');
    Route::get('/tiempos-resolucion-tipo/pdf', [InformeController::class, 'informeTiemposResolucionPorTipoPdf'])->name('export.informe.tiempos.resolucion.tipo.Pdf');

    Route::get('/tiempo-dedicado-e-incidencias-admin', [InformeController::class, 'informeTiempoDedicadoEIncidenciasPorAdministrador'])->name('export.informe.tiempo.dedicado.e.incidencias.admin');
    Route::get('/tiempo-dedicado-e-incidencias-admin/csv', [InformeController::class, 'informeTiempoDedicadoEIncidenciasPorAdministradorCsv'])->name('export.informe.tiempo.dedicado.e.incidencias.admin.Csv');
    Route::get('/tiempo-dedicado-e-incidencias-admin/pdf', [InformeController::class, 'informeTiempoDedicadoEIncidenciasPorAdministradorPdf'])->name('export.informe.tiempo.dedicado.e.incidencias.admin.Pdf');
});

```

Y estas rutas se procesan en el nav, con un dropdown en un boton con un icono

```php
 <!-- Nav Item - Informes -->
                    <li class="nav-item dropdown bg-gradient-primary">
                        <a class="nav-link dropdown-toggle texto-nav d-flex" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-speedometer2 px-1"></i>
                            <span>Informes</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap">
                                    Informe resueltas por admin
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>

                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap">
                                    Informe Abiertas por Usuario
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Informe Estadisticas tipos
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Tiempo Dedicado por Incidencia
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Informe Tiempos Resolución por Tipo
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap px-2">
                                    Informe Tiempo Dedicado e Incidencias por Admin
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

```

## DESARROLLO DE APLICACIONES WEB EN ESTORNO CLIENTE

Para la aplicación de elementos dinamicos y el proceso de filtrado de incidencias sin necesidad de recargar la página, utilizaremos javaScript y AJAX para la conexión entre php y el propio javaScript.

### JavaScript puro

En cuanto a javaScript puro, utilizamos los siguientes métodos para la carga de subtipos y sub-subtipos en el formulario de creación de la incidencia

```js
<script>
                    window.addEventListener('load', inicio, false);
                    let array = new Array();
                    /**
                     * Array de pruebas con los tipos y subtipos de incidencias
                     */
                    array['EQUIPOS'] = ['PC', 'ALTAVOCES', 'MONITOR', 'PROYECTOR', 'PANTALLA', 'PORTATIL', 'IMPRESORAS'];
                    array['CUENTAS'] = ['EDUCANTABRIA', 'GOOGLE CLASSROOM', 'DOMINIO', 'YEDRA'];
                    array['WIFI'] = ['Iesmiguelherrero', 'WIECAN'];
                    array['SOFTWARE'] = ['INSTALACION', 'ACTUALIZACION'];
                    array['EQUIPOS']['PC'] = ['RATON', 'ORDENADOR', 'TECLADO'];
                    array['EQUIPOS']['PORTATIL'] = ['PROPORCIONADO POR CONSERJERIA', 'DE AULA'];

                    /**
                     * Metodo que añade los eventos a los combos pertinentes
                     *
                     * @param {none} no recibe nada
                     * @return {none} no devuelve nada al ser un metodo void
                     */
                    function inicio() {
                        console.log(document.getElementById('nombre').value);
                        document.getElementById('tipo').addEventListener('change', rellenar1, false);
                        document.getElementById('subtipo').addEventListener('change', rellenar2, false);
                    }

                    /**
                     * Metodo que rellena el segundo select segun los datos del array de subtipos
                     *
                     * @param {none} no recibe nada
                     * @return {none} no devuelve nada al ser un metodo void
                     */
                    function rellenar1() {
                        let opc = document.getElementById('tipo').value;
                        console.log(opc);
                        let sel = document.getElementById('subtipo');
                        sel.innerHTML = '';
                        //solo actualizará los datos si la opción es distinta a INTERNET
                        document.getElementById('sel1').classList.remove('invisible');
                        sel.innerHTML += `<option value=null selected>...</option>`;
                        switch (opc) {
                            case "EQUIPOS":
                                var arr = array['EQUIPOS'];
                                for (let i = 0; i < arr.length; i++) {
                                    document.getElementById('sel1').classList.remove('invisible');
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    //Con esta linea hago que la caja de informacion del equipo sea visible
                                    document.getElementById('info-equipo').classList.remove('invisible');
                                }

                                break;
                            case "CUENTAS":
                                var arr = array['CUENTAS'];
                                document.getElementById('sel1').classList.remove('invisible');
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    document.getElementById('info-equipo').classList.add('invisible');
                                }
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                            case "WIFI":
                                document.getElementById('sel1').classList.remove('invisible');
                                var arr = array['WIFI'];
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    document.getElementById('info-equipo').classList.add('invisible');
                                }
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                            case "SOFTWARE":
                                document.getElementById('sel1').classList.remove('invisible');
                                var arr = array['SOFTWARE'];
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    document.getElementById('info-equipo').classList.add('invisible');
                                }
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                            case "INTERNET":
                                document.getElementById('sel1').classList.add('invisible');
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                            default:
                                document.getElementById('sel1').classList.add('invisible');
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                        }

                    }

                    /**
                     * Metodo que rellena el tercer select con los datos del array de sub-subtipos
                     *
                     * @param {none} no recibe nada
                     * @return {none} no devuelve nada al ser un metodo void
                     */
                    function rellenar2() {
                        let opc = document.getElementById('subtipo').value;
                        console.log(opc);
                        let selec = document.getElementById('sub_subtipo');
                        selec.innerHTML = '';
                        switch (opc) {
                            case opc = "PC":
                                document.getElementById('sel2').classList.remove('invisible');
                                var arr = array['EQUIPOS']['PC'];
                                for (let i = 0; i < arr.length; i++) {
                                    selec.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                }

                                break;
                            case "PORTATIL":
                                document.getElementById('sel2').classList.remove('invisible');
                                var arr = array['EQUIPOS']['PORTATIL'];
                                for (let i = 0; i < arr.length; i++) {
                                    selec.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                }
                                break;
                            default:
                                //hace invisible el select si no es necesario para la opción
                                document.getElementById('sub_subtipo').value = null;
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                        }
                    }
                </script>
```

Este script carga automaticamente los combos de subtipo y sub_subtipo, mostrandolos solo cuando es necesario, y haciendolos invisibles cuando no lo sean. Para cargar los valores se utiliza un array asociativo bidimensional y para mostrar u ocultar informacion se utiliza el metodo classlist.add() o classlist.remove() con la clase de css bootstrap invisible.

Como podemos observar si se seleciona la opcion equipos, también se quita la clase invisible de la información de los equipos pertinente.

```js
<script>
                    var equipos = @json($equipos);
                    var equipoSelect = document.getElementById('numero_etiqueta');
                    /**
                     * Metodo que rellena el combo de equipos segun los equipos del aula seleccionada en el primer combo
                     *
                     * @param {none} no recibe nada
                     * @return {none} no devuelve nada al ser un metodo void
                     */
                    document.getElementById('aula').addEventListener('change', function() {
                        var selectedAulaNum = parseInt(document.getElementById('aula').value);
                        // Limpiar el select de equipos
                        equipoSelect.innerHTML = '';
                        equipoSelect.innerHTML = `<option selected value="null">...</option>`;
                        // Filtrar los equipos por el número de aula seleccionadovar
                        equiposFiltrados = equipos.filter(function(equipo) {
                            return equipo.aula_num === selectedAulaNum;
                        });
                        // Llenar el select de equipos filtrados
                        equiposFiltrados.forEach(function(equipo) {
                            var option = document.createElement("option");
                            option.text = equipo.etiqueta;
                            option.value = equipo.etiqueta;
                            equipoSelect.add(option);
                        });
                    });
                    /**
                     * Metodo que rellena la informacion del puesto en el aula según la etiqueta del equipo seleccionada
                     *
                     * @param {none} no recibe nada
                     * @return {none} no devuelve nada al ser un metodo void
                     */
                    document.getElementById('numero_etiqueta').addEventListener('change', function() {
                        var selectedEquipo = parseInt(document.getElementById('numero_etiqueta').value);
                        var puesto;
                        for (let i = 0; i < equiposFiltrados.length; i++) {
                            if (equiposFiltrados[i].etiqueta == selectedEquipo) {
                                puesto = equiposFiltrados[i].puesto;
                            }
                        }
                    });
                </script>
```

El segundo script que vemos en el formulario de crear incidencias carga dinamicamente los equipos de cada aula según un array introducido en formato json mediante ajax.

Así mismo, para mostrar los documentos adjuntos a cada incidencia, e indicar gráficamente el tipo de docuemento, utilizamos el siguente método en la vista de mostrar

```js
<script>
            var cadena = document.getElementById('ruta').textContent;
            console.log(cadena);
            /**
             * Metodo que rellena la informacion del puesto en el aula según la etiqueta del equipo seleccionada
             *
             * @param string recibe una cadena con el nombre del archivo adjunto
             * @return string devuelve una cadena con la extension del archivo adjunto
             */
            function obtenerContenidoDesdeCaracter(cadena) {
                const indiceCaracter = cadena.indexOf('.');
                if (indiceCaracter !== -1) {
                    const contenidoDesdeCaracter = cadena.substring(indiceCaracter + 1);
                    return contenidoDesdeCaracter;
                } else {
                    console.error(`El carácter "${caracter}" no se encontró en la cadena.`);
                    return null;
                }
            }
            var opc = obtenerContenidoDesdeCaracter(cadena);
            //segun la cadena que le llega, este switch le añade una imagen descriptiva de la extensión del archivo a la caja de archivos
            switch (opc) {
                case "jpg":
                    document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                                                                </svg>`;
                    break;
                case "pdf":
                    document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                                                    </svg>`;
                    break;
                case "csv":
                    document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-spreadsheet-fill" viewBox="0 0 16 16">
                                                                <path d="M12 0H4a2 2 0 0 0-2 2v4h12V2a2 2 0 0 0-2-2m2 7h-4v2h4zm0 3h-4v2h4zm0 3h-4v3h2a2 2 0 0 0 2-2zm-5 3v-3H6v3zm-4 0v-3H2v1a2 2 0 0 0 2 2zm-3-4h3v-2H2zm0-3h3V7H2zm4 0V7h3v2zm0 1h3v2H6z"/>
                                                                </svg>`;
                    break;
                case "rtf":
                    document.getElementById('simbolo').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-word-fill" viewBox="0 0 16 16">
                                                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.485 6.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 9.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
                                                                </svg>`;
                    break;
            }
        </script>
```

Este script primero obtiene la extesion del archivo adjunto mediante un metodo. Esta cadena resultante con la extesión del archivo se introduce en un switch que introducirá una imagen descriptiva según el tipo de documento a la caja de archivos

### Filtrado de incidencias

Para el filtrado de incidencias, se genera el siguiente metodo en el controlador de incidencias

```php
  /**
     * Metodo para filtrar las las incidencias
     * @param Request $request
     * @return mixed Devuelve una vista con todas las incidencias
     */
    public function filtrar(Request $request)
    {


        $query = Incidencia::query();

        //saco el id del usuario logeado actualmente
        $user = auth()->user();

        if ($user->hasRole('Profesor')) {
            $query->where('creador_id', $user->id);
        }

        // Filtrar por cada parámetro recibido
        if ($request->has('descripcion') && $request->filled('descripcion')) {
            $query->where('descripcion', 'like', '%' . $request->input('descripcion') . '%');
        }

        if ($request->has('tipo') && $request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->input('tipo') . '%');
        }

        if ($request->has('estado') && $request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->input('estado') . '%');
        }

        if ($request->has('creador') && $request->filled('creador')) {
            $query->join('users', 'incidencias.creador_id', '=', 'users.id')
                ->where('users.nombre_completo', 'LIKE', '%' . $request->input('creador') . '%');
        }

        if ($request->has('prioridad') && $request->filled('prioridad')) {
            $query->where('prioridad', 'like', '%' . $request->input('prioridad') . '%');
        }

        if ($request->has('aula') && $request->filled('aula')) {
            $incidencias = Incidencia::join('equipos', 'equipos.id', '=', 'incidencias.equipo_id')
                ->join('aulas', 'aulas.num', '=', 'equipos.aula_num')
                ->where('aulas.num', $request->aula);
            //where('aula', '=', $request->input('aula'));
        }



        if ($request->has('desde') && $request->has('hasta') && $request->filled('desde') && $request->filled('hasta')) {
            $desde = date($request->input('desde'));
            $hasta = date($request->input('hasta'));

            $query->whereBetween('fecha_creacion', [$desde, $hasta])->get();
        }


        $usuarios = User::all();
        $aulas = Aula::all();

        $incidencias = $query->paginate(10);

        return view('incidencias.index', ['incidencias' => $incidencias, 'aulas' => $aulas, 'usuarios' => $usuarios]);
    }
```

Este metodo recoge los datos del formulario de filtrado y devuelve una respuesta de la base de datos con los dtos filtrados según la selección, que luego se mostrarán en la vista index

Este método se traduce en el siguiente formulario en la vista index

```php
<div class="collapse my-2" id="collapseExample">
            <form class="card card-body" id="formFiltros" action='{{ route('incidencias.filtrar') }}' method="POST">
                @csrf
                <div class="row my-1 gap-3">
                    <div class="col-md-4">
                        <input type="text" id="descripcion" name="descripcion" class="form-control"
                            placeholder="Descripción">
                    </div>
                    <div class="col-md-2">
                        <select id="tipo" name="tipo" class="form-select">
                            <option value="">--Tipo--</option>
                            <option value="EQUIPOS">EQUIPOS</option>
                            <option value="CUENTAS">CUENTAS</option>
                            <option value="WIFI">WIFI</option>
                            <option value="SOFTWARE">SOFTWARE</option>
                            <option value="INTERNET">INTERNET</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <select id="aula" name="aula" class="form-select">
                            <option value="">--Aula--</option>
                            @foreach ($aulas as $aula)
                                <option value="{{ $aula->num }}">{{ $aula->codigo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="estado" id="estado" class="form-select">
                            <option value="">--Estado--</option>
                            <option value="abierta">Abierta</option>
                            <option value="en proceso">En proceso</option>
                            <option value="asignada">Asignada</option>
                            <option value="enviada a Infortec">Enviada a Infortec</option>
                            <option value="resuelta">Resuelta</option>
                            <option value="cerrada">Cerrada</option>
                        </select>
                    </div>


                    <div class="col-md-2">
                        <select name="prioridad" id="prioridad" class="form-select">
                            <option value="">--Prioridad--</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>

                </div>
                <div class="row my-1">
                    @hasrole('Administrador')
                        <div class="col-md-3">
                            <select id="creador" name="creador" class="form-select">
                                <option value="">--Creador--</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->nombre_completo }}">{{ $usuario->nombre_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endhasrole


                    <div class="col-md-3">
                        <select id="responsable" name="responsable" class="form-select">
                            <option value="">--Responsable--</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->nombre_completo }}">{{ $usuario->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-2" id="select-fechas">
                        <label for="desde">Desde:</label>
                        <input type="date" id="desde" name="desde" class="form-control">
                    </div>


                    <div class="col-md-2" id="select-fechas">
                        <label for="hasta">Hasta:</label>
                        <input type="date" id="hasta" name="hasta" class="form-control">
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary text-white ">Filtrar</button>
                </div>
            </form>
        </div>

```

Como podemos observar, los datos de aulas, responsables y creadores se cargan dinamicamente según los datos en la base de datos. Así mismo el combo de buscar por creador solo aparacerá en el caso de que el usuario sea administrador

Para que estos datos sean filtrados correctamente y se serializen, generamos el siguiente método de JavaScript

```js
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Maneja el envío del formulario de filtros
            $('#formFiltros').submit(function(event) {
                event.preventDefault(); // Evita que se recargue la página al enviar el formulario
                filtrar(); // Llama a la función de filtrar
            });

            // Función para filtrar mediante AJAX
            function filtrar() {
                $.ajax({
                    url: '{{ route('incidencias.filtrar') }}', // Ruta definida en las rutas de Laravel
                    type: 'POST',
                    data: $('#formFiltros').serialize(), // Serializa los datos del formulario
                    success: function(response) {
                        $('#lista-incidencias').html(response); // Actualiza la lista de incidencias
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Maneja los errores, si los hay
                    }
                });
            }
        });
    </script>
```

Este método primero previene el comportamiento por defecto del formulario, para después enviarlo a la ruta deseada seleccionando los datos del formulario. Después actualiza el listado de incidencias según la respuesta que le llega del controlador, transformando los datos a html y controlando cualquier error que pudiera suceder

### Charts

También utilizaremos AJAX para generar gráficos en una vista dashboard.

Para empezar tendremos un controlador DashController para que el enlace del menu nos lleve a la vista adecuada mediante el metodo index enviando en una variable las incidencias
 ```php
 <?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class DashController extends Controller
{
    /**
     * Devuelve la vista del dashboard
     *
     * @return mixed Devuelve una vista ¡¡
     */
    public function index()
    {

        $incidencias = Incidencia::all();

        return view('dashboard.index', ['incidencias' => $incidencias]);
    }
}
 ```

Despues en la vista dashboard.index.blade.php, screan elementos canvas de html. En este elemento puedes insertar lo que quieras, por lo que es el elemnto perfecto para hacer las gráficas

Después en el script de JavaScript, se pasa la variable incidencias de php a formato Json. Despues se cuentan las incidencias por distintos parámetros como por el estado de resolución, el creador, por prioridad y por su responsable. Después se crea la gráfica y se le da estilos
```js
<div class="border-1 rounded-4 p-2 d-flex ">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por tipo:
            <canvas id="tipoChart" width="100" height="100"></canvas>
        </div>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por prioridad:
            <canvas id="prioridadChart" width="100" height="100"></canvas>
        </div>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por estado:
            <canvas id="estadoChart" width="100" height="100"></canvas>
        </div>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por Administrador:
            <canvas id="responsableChart" width="100" height="100"></canvas>
        </div>

        <script>
            var jsonData = @json($incidencias);
            console.log(jsonData);

            document.addEventListener("DOMContentLoaded", function() {

                // Función para contar incidencias por tipo
                function contarIncidenciasPorTipo(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.tipo] = (counts[item.tipo] || 0) + 1;
                    });
                    return counts;
                }

                // Función para contar incidencias por prioridad
                function contarIncidenciasPorPrioridad(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.prioridad] = (counts[item.prioridad] || 0) + 1;
                    });
                    return counts;
                }

                // Función para contar incidencias por estado
                function contarIncidenciasPorEstado(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.estado] = (counts[item.estado] || 0) + 1;
                    });
                    return counts;
                }

                function contarIncidenciasPorResponsable(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.responsable_id] = (counts[item.responsable_id] || 0) + 1;
                    });
                    return counts;
                }

                // Obtener los recuentos
                var incidenciasPorTipo = contarIncidenciasPorTipo(jsonData);
                var incidenciasPorPrioridad = contarIncidenciasPorPrioridad(jsonData);
                var incidenciasPorEstado = contarIncidenciasPorEstado(jsonData);
                var incidenciasPorResponsable = contarIncidenciasPorResponsable(jsonData);

                // Configurar los gráficos
                var tipoCtx = document.getElementById('tipoChart').getContext('2d');
                var tipoChart = new Chart(tipoCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(incidenciasPorTipo),
                        datasets: [{
                            label: 'Incidencias por Tipo',
                            data: Object.values(incidenciasPorTipo),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });

                var prioridadCtx = document.getElementById('prioridadChart').getContext('2d');
                var prioridadChart = new Chart(prioridadCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(incidenciasPorPrioridad),
                        datasets: [{
                            label: 'Incidencias por Prioridad',
                            data: Object.values(incidenciasPorPrioridad),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });

                var estadoCtx = document.getElementById('estadoChart').getContext('2d');
                var estadoChart = new Chart(estadoCtx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(incidenciasPorEstado),
                        datasets: [{
                            label: 'Incidencias por Estado',
                            data: Object.values(incidenciasPorEstado),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });

                // Configurar los datos para el gráfico
    var responsables = Object.keys(incidenciasPorResponsable);
    var incidenciasPorResponsableData = Object.values(incidenciasPorResponsable);

    // Configurar el gráfico con Chart.js
    var responsableCtx = document.getElementById('responsableChart').getContext('2d');
    var responsableChart = new Chart(responsableCtx, {
        type: 'bar',
        data: {
            labels: responsables,
            datasets: [{
                label: 'Incidencias por Responsable',
                data: incidenciasPorResponsableData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
            });
        </script>
    </div>
```

## DISEÑO DE INTERFACES WEB

Para empezar, necesitaremos unos wireframes para guiar la programación y la aplicación de estilos para nuestra web.

(insertar wireframes y explicacion)

Una vez generados los wireframes, realizamos una guía de estilos para seguir en la aplicación, y que se muestre de una forma coherente.

(insetar guia de estilos y explicacion)

Suigiendo esta guía de estilos y de acuerdo con loos wireframes, se crea una plantilla de blade que seguirán todas las vistas y que incluirá las partes gráficas comunes como son el header, el navegador o el footer.

La plantilla es la base de nuestros estilos. En ela incluimos las estiquetas meta, cualquier link de scripts que necesitamos para los estilos o la extension sweetalert e incluimos loas parciales
``` html
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>@yield('titulo')</title>
    @vite('resources/sass/app.scss', 'resources/js/app.js')
</head>

<body class="bg-colorPrincipal">
    @include('layouts.partials.header')

    <main class="row g-0">
        <div class="col-2">
            @include('layouts.partials.nav')
        </div>
        <div class="col-10 p-5">
            @yield('contenido')
        </div>
    </main>
    @include('layouts.partials.footer')

</body>

</html>
```
El primer parcial será el header incluirá el logo, en nombre de la página, y la imagen del usuario, que dependiendo de si es profesor o administrador cambiará. A esta imagen se le asocia un dropdown con el enlace a la gestion del usuario

```html
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

<header class="navbar navbar-expand col-12 navbar-light bg-white shadow ml-auto d-flex justify-content-between">
    <div class="mx-4">
        <img class="img-logo" src={{ asset('assets/imagenes/logo_insti.svg') }}>
        <span id="span-titulo" >Gestión de Incidencias</span>
    </div>
    <div class="dropdown px-5 col-auto">
        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
            data-bs-toggle="dropdown" aria-expanded="false">
            @if (Auth::check())

            <span class="mr-2 small">{{ auth()->user()->nombre }}</span>
            @hasrole('Administrador')
                <svg  class="img-profile rounded-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M224 0a128 128 0 1 1 0 256A128 128 0 1 1 224 0zM178.3 304h91.4c11.8 0 23.4 1.2 34.5 3.3c-2.1 18.5 7.4 35.6 21.8 44.8c-16.6 10.6-26.7 31.6-20 53.3c4 12.9 9.4 25.5 16.4 37.6s15.2 23.1 24.4 33c15.7 16.9 39.6 18.4 57.2 8.7v.9c0 9.2 2.7 18.5 7.9 26.3H29.7C13.3 512 0 498.7 0 482.3C0 383.8 79.8 304 178.3 304zM436 218.2c0-7 4.5-13.3 11.3-14.8c10.5-2.4 21.5-3.7 32.7-3.7s22.2 1.3 32.7 3.7c6.8 1.5 11.3 7.8 11.3 14.8v17.7c0 7.8 4.8 14.8 11.6 18.7c6.8 3.9 15.1 4.5 21.8 .6l13.8-7.9c6.1-3.5 13.7-2.7 18.5 2.4c7.6 8.1 14.3 17.2 20.1 27.2s10.3 20.4 13.5 31c2.1 6.7-1.1 13.7-7.2 17.2l-14.4 8.3c-6.5 3.7-10 10.9-10 18.4s3.5 14.7 10 18.4l14.4 8.3c6.1 3.5 9.2 10.5 7.2 17.2c-3.3 10.6-7.8 21-13.5 31s-12.5 19.1-20.1 27.2c-4.8 5.1-12.5 5.9-18.5 2.4l-13.8-7.9c-6.7-3.9-15.1-3.3-21.8 .6c-6.8 3.9-11.6 10.9-11.6 18.7v17.7c0 7-4.5 13.3-11.3 14.8c-10.5 2.4-21.5 3.7-32.7 3.7s-22.2-1.3-32.7-3.7c-6.8-1.5-11.3-7.8-11.3-14.8V467.8c0-7.9-4.9-14.9-11.7-18.9c-6.8-3.9-15.2-4.5-22-.6l-13.5 7.8c-6.1 3.5-13.7 2.7-18.5-2.4c-7.6-8.1-14.3-17.2-20.1-27.2s-10.3-20.4-13.5-31c-2.1-6.7 1.1-13.7 7.2-17.2l14-8.1c6.5-3.8 10.1-11.1 10.1-18.6s-3.5-14.8-10.1-18.6l-14-8.1c-6.1-3.5-9.2-10.5-7.2-17.2c3.3-10.6 7.7-21 13.5-31s12.5-19.1 20.1-27.2c4.8-5.1 12.4-5.9 18.5-2.4l13.6 7.8c6.8 3.9 15.2 3.3 22-.6c6.9-3.9 11.7-11 11.7-18.9V218.2zm92.1 133.5a48.1 48.1 0 1 0 -96.1 0 48.1 48.1 0 1 0 96.1 0z"/></svg>
            @else
                <svg class="img-profile rounded-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            @endhasrole
            @endif
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            @if (Auth::check())

                <li>
                    <a class="dropdown-item" href="{{route('usuarios.show',auth()->user())}}">
                        <i class="bi bi-person-fill"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <form class="dropdown-item" id="logout-form" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <i class="bi bi-box-arrow-right"></i>
                        <input class="border-0 bg-light" type="submit" value="Logout">
                    </form>

                </li>
            @endif
        </ul>
    </div>
</header>

```

El navegador incluirá los enlaces a las diferentes páginas de la aplicación, ocultando las inaccesibles al profesor 

```html
<nav class="navbar navbar-expand-md bg-gradient-primary p-3 d-flex flex-column align-content-start" id="sidebar">
    <div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex flex-column g-2">
                <!-- Nav Item - Listado de Incidencias -->
                <li class="nav-item">
                    <a class="nav-link texto-nav d-flex" href="{{ route('incidencias.index') }}">
                        <i class="bi bi-list-ul px-1"></i>
                        <span>Listado Incidencias</span>
                    </a>
                </li>
                @hasrole('Administrador')
                    <!-- Nav Item - Informes -->
                    <li class="nav-item dropdown bg-gradient-primary">
                        <a class="nav-link dropdown-toggle texto-nav d-flex" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-speedometer2 px-1"></i>
                            <span>Informes</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap">
                                    Informe resueltas por admin
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>

                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap">
                                    Informe Abiertas por Usuario
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Informe Estadisticas tipos
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Tiempo Dedicado por Incidencia
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Informe Tiempos Resolución por Tipo
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap px-2">
                                    Informe Tiempo Dedicado e Incidencias por Admin
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- Nav Item - Gestion Usuario -->
                    <li class="nav-item">
                        <a class="nav-link texto-nav d-flex" href="{{ route('usuarios.index') }}">
                            <i class="bi bi-person-lines-fill px-1"></i>
                            <span>Gestión Usuario</span>
                        </a>
                    </li>


                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link texto-nav d-flex" href="{{ route('dashboard.index') }}">
                            <i class="bi bi-speedometer px-1"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Nav Item - aulas -->
                    <li class="nav-item">
                        <a class="nav-link texto-nav d-flex" href="{{ route('aulas.index') }}">
                            <i class="bi bi-house px-1"></i>
                            <span>Aulas</span>
                        </a>
                    </li>


                   <!-- Nav Item - Dashboard -->
                   <li class="nav-item">
                    <a class="nav-link texto-nav d-flex" href="{{ route('equipos.index') }}">
                        <i class="bi bi-pc-display px-1"></i>
                        <span>Equipos</span>
                    </a>
                </li>
                @endhasrole
            </ul>
        </div>
    </div>
</nav>
```
En el footer simplemente incluimos el copyright

```html
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Grupo 3</span>
        </div>
    </div>
</footer>
```

### Formularios

Para los estilos de los formularios, lo más importante es agrupar la información de manera coherente, dejar claros los datos y hacerlo no muy pesado para la vista y dejar claro que elementos se pueden editar y cuales no

Por ello para crear una incidencia por ejemplo se crea el siguiente formulario, usando clases de bootstrap para agrupar y poner en la misma línea datos relacionados como el tipo y los subtipos.

```php
 <div id="caja-formulario" class="container">
        <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data"
            class="form-horizantal">
            @csrf
            <div class="col-sm-12">
                <label for="nombre" class="form-label">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control readonly-custom"
                    value="{{ $user = auth()->user()->nombre_completo }}" readonly>
            </div>
            <div class="row">
                @if ($user = auth()->user()->email)
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label for="correo_asociado" class="form-label col-sm-4">Correo electrónico:</label>
                            <div class="col-sm-12">
                                <input type="correo_asociado" id="correo_asociado" name="correo_asociado"
                                    class="form-control readonly-custom" value={{ $user = auth()->user()->email }} readonly>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label for="correo_asociado" class="form-label col-sm-4">Correo electrónico:</label>
                            <div class="col-sm-12">
                                <input type="correo_asociado" id="correo_asociado" name="correo_asociado"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="departamento" class="form-label col-sm-4">Departamento:</label>
                        <div class="col-sm-12">
                            @if ($user = auth()->user()->departamento)
                                <input type="text" id="departamento" name="departamento"
                                    value={{ $user = auth()->user()->departamento->nombre }}
                                    class="form-control readonly-custom" readonly>
                            @else
                                <select id="departamento" name="departamento" class="form-select">
                                    <option selected="true">...</option>
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select">
                        <option selected="true" value>...</option>
                        <option value="EQUIPOS">Equipos</option>
                        <option value="CUENTAS">Cuentas</option>
                        <option value="WIFI">Wifi</option>
                        <option value="SOFTWARE">Software</option>
                        <option value="INTERNET">Internet</option>
                    </select>
                </div>
                <div id="sel1"class="col-sm-4 invisible">
                    <label for="subtipo" class="form-label">Subtipo:</label>
                    <select id="subtipo" name="subtipo" class="form-select"></select>
                </div>
                <div id="sel2"class="col-sm-4 invisible">
                    <label for="sub_subtipo" class="form-label">Sub_subtipo</label>
                    <select id="sub_subtipo" name="sub_subtipo" class="form-select"></select>
                </div>
            </div>

            <div class="form-outline col-sm-12">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="adjunto" class="form-label col-sm-4">Archivo Adjunto:</label>
                        <div class="col-sm-12">
                            <input type="file" id="adjunto" name="adjunto" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row invisible" id="info-equipo">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="aula" class="form-label col-sm-4">Aula:</label>
                        <div class="col-sm-12">

                            <select id="aula" name="aula" class="form-select">
                                <option selected>...</option>
                                @foreach ($aulas as $aula)
                                    <option value="{{ $aula->num }}">{{ $aula->codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="numero_etiqueta " class="form-label col-sm-4">Etiqueta del equipo:</label>
                        <div class="col-sm-12">
                            <select id='numero_etiqueta' name='numero_etiqueta' class="form-select">
                                <option selected value="null">...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="puesto" class="form-label col-sm-4">Puesto en el aula:</label>
                        <input type="text" id="puesto" name="puesto" class="form-control readonly-custom"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <input type="submit" id="crear "class="btn btn-primary col-sm-2 text-white" value="Crear Incidencia">
            </div>
        </form>
```

Este formulario también carga los datos de usuarios y aulas de manera dinámica, recibiendo tambien el nombre, correo y departamaneto si los hubiera del usuario autenticado

Las clases row hacen que el contenido se muestre en línea y no como columna y las clases col-sm-(numero) modifiacan el tamaño dentro de las 12 columnas que genera bootstrap por defecto

Las unicas clases de css customizadas para los formularios son la caja, para darle fondo y el borde de color y el readonly, pus bootstrap solo le da estilo a los disabled que dan problemas a la hora de mandar datos al controlador

La clase readonly-custom le da un fondo gris a los datos readonly que no se pueden editar en los formularios

```css
.readonly-custom {
  background-color: #c3ccd8;
  color: #363535;
}
```

### Mostrar información

Para mostrar la información en la vista de listado generamos una tabla usando las clases de bootstrap, usando la clase table-responsive y la clase col para las comunas
```js
<div class="table-responsive">
                <table id="tablaIncidencias" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Creado por</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Prioridad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incidencias as $incidencia)
                            <tr class="align-middle" scope="row">
                                <td class="text-truncate">{{ $incidencia->id }}</td>
                                <td class="text-truncate">{{ $incidencia->fecha_creacion }}</td>
                                <td class="text-truncate" style="max-width: 150px;">{{ $incidencia->descripcion }}</td>
                                <td class="text-truncate">{{ $incidencia->tipo }}</td>
                                <td class="text-truncate">
                                    @empty($incidencia->equipo)
                                        Sin aula
                                    @else
                                        {{ $incidencia->equipo->aula->codigo }}
                                    @endempty
                                </td>
                                <td class="text-truncate">{{ $incidencia->creador->nombre_completo }}</td>
                                <td class="text-truncate">
                                    @empty($incidencia->responsable_id)
                                        Todavía no asignado
                                    @else
                                        {{ $incidencia->responsable->nombre_completo }}
                                    @endempty
                                </td>
                                <td class="text-truncate">{{ $incidencia->estado }}</td>
                                <td class="text-truncate">
                                    @empty($incidencia->prioridad)
                                        Todavía no asignado
                                    @else
                                        {{ $incidencia->prioridad }}
                                    @endempty
                                </td>
                                <td>
                                    <div class="d-flex gap-3">


                                        <a class="btn btn-primary text-white" role="button"
                                            href="{{ route('incidencias.show', $incidencia) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @hasrole('Administrador')
                                            <a class="btn btn-success" role="button"
                                                href="{{ route('incidencias.edit', $incidencia) }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endhasrole

                                        @hasrole('Administrador')
                                            <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST"
                                                id="formBorrar">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                            <script>
                                                // Seleccionar todos los elementos con el id #formBorrar
                                                var forms = document.querySelectorAll('#formBorrar');

                                                // Iterar sobre cada elemento y agregar un evento de escucha
                                                forms.forEach(function(form) {
                                                    form.addEventListener('submit', function(e) {
                                                        e.preventDefault();

                                                        var currentForm = this;

                                                        swal({
                                                            title: "Borrar Incidencia",
                                                            text: "¿Quieres borrar la incidencia?",
                                                            icon: "warning",
                                                            buttons: [
                                                                'No, cancelar',
                                                                'Si, Estoy Seguro'
                                                            ],
                                                            dangerMode: true,
                                                        }).then(function(isConfirm) {
                                                            if (isConfirm) {
                                                                swal({
                                                                    title: '¡HECHO!',
                                                                    text: 'La incidencia ha sido borrada',
                                                                    icon: 'success'
                                                                }).then(function() {
                                                                    currentForm.submit();
                                                                });
                                                            } else {
                                                                swal("Cancelado", "La incidencia no ha sido eliminada", "error");
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>

                                        @endhasrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
```

Por ultimo para mostrar los datos en la vista show usamos tambien la clase del id caja-formulario para incluirlo todo en una caja con fondo blanco, usamos bootstrap para alinear los datos y una clase custom para darle un borde a las cajas de informacion, actuaciones y archivos

```css
.descripcion {
    border: 2px #737c86 solid;
    border-radius: 5px;
    padding: 1%;
    margin-bottom: 10px;
}

.caja-archivos {
    border: 2px #737c86 solid;
    border-radius: 5px;
    padding: 1%;
    margin: 5px;
    height: 60%;
}
```

### Modales

Para generar los modales hemos utilizado la librerí externa sweetalert2, que como funcina con javaScript y CSS se instala con el comando npm install.

Esta librería contiene elementos animados y acciones y metodos propios, como el metodo Swal que es el que lanza el modal. De esta forma hemos hecho modales de confirmación en la edicion y el borrado de inciedencias, usuarios, equipos y aulas 

```js
<script>
                /**
                 * Metodo que lanza un modal al pulsar el botón de editar incidencia, hace que se controle si se quieren guardar los cambios o no
                 *
                 * @param mixed recibe un formulario para prevenir su funcionamiento por defecto
                 * @return {none} no devuelve nada, ejecuta acciones según los botones que se pulsan
                 */
                document.querySelector('#formulario1').addEventListener('submit', function(e) {
                    var form = this;

                    e.preventDefault();

                    swal({
                        title: "GUARDAR CAMBIOS",
                        text: "¿Quieres guardar los cambios en la incidencia?",
                        icon: "warning",
                        buttons: [
                            'No, cancelar',
                            'Si, Estoy Seguro'
                        ],
                        dangerMode: true,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: '¡HECHO!',
                                text: 'La incidencia ha sido editada',
                                icon: 'success'
                            }).then(function() {
                                form.submit();
                            });
                        } else {
                            swal("Cancelado", "La incidencia no ha sido editada", "error");
                        }
                    });
                });
            </script>
``` 
Como podemos observar primero desactivamos el comportaiento por defecto del formulario y lanza el modal sustituyendo este comportamiento

## DESPLIEGUE DE APLICACIONES WEB
 
## Requirements
 
Paquete | Version
--- | ---
[Node](https://nodejs.org/en/) | V20.19.1+
[Npm](https://nodejs.org/en/)  | V6.14.16+
[Composer](https://getcomposer.org/)  | V2.2.6+
[Php](https://www.php.net/)  | V8.0.17+
[Mysql](https://www.mysql.com/)  |V 8.0.27+
 
## Installation
 
> **Warning**
> Asegurate de cumplir todos los requerimiento antes de ejecutar.
 
Para ejecutar el proyecto en local
1. Clonar el repositorio
    ```sh
    git clone https://github.com/D0nP3ngu1n/GestionIncidencias.git
    ```
 
1. Vamos a la carpeta del proyecto
    ```shs
    cd /GestionIncidencias
    ```
 
1. Vamos a la carpeta del proyecto
    ```sh
    composer install
    ```
 1. Vamos a la carpeta del proyecto
    ```sh
    npm install
    ```
1. Copy .env.example file to .env file
    ```sh
 
    ```
 
Clonado del respositorio de github, en la carpeta /var/www/.
```sh
git clone https://github.com/D0nP3ngu1n/GestionIncidencias.git
```
 
 
Configuracion de apache
```sh
<VirtualHost *:80>
 
#Nombre y administrador del proyecto
    ServerName GestionDeIncidencias
    ServerAdmin dpradom01@educantabria.es
#carpeta raiz del proyecto
 
    DocumentRoot /var/www/GestionIncidencias/public
 
    <Directory /var/www/GestionIncidencias>
       AllowOverride All
   </Directory>
 
    ErrorLog ${APACHE_LOG_DIR}/errorProyecto.log
    CustomLog ${APACHE_LOG_DIR}/accessProyecto.log combined
    #Include conf-available/serve-cgi-bin.conf
 
</VirtualHost>
```
Clonado del respositorio de github, en la carpeta /var/www/.
```
git clone https://github.com/D0nP3ngu1n/GestionIncidencias.git
```
[15:23] Manuel Llano  Revanal
## DESPLIEGUE DE APLICACIONES WEB
 
[![Made with MySQL](https://img.shields.io/badge/MySQL->=8.0.27-yellow?logo=mysql&logoColor=white)](https://www.mysql.com/ "Go to MySQL homepage") [![Made with PHP](https://img.shields.io/badge/php-8.2-blue?logo=php&logoColor=white)](https://www.php.com/ "Go to MySQL homepage") [![Made with Node.js](https://img.shields.io/badge/Node.js-20.1-gree?logo=node.js&logoColor=white)](https://nodejs.org "Go to Node.js homepage") [![Made with composer](https://img.shields.io/badge/composer-2.6.5-gree?logo=composer&logoColor=white)](https://composer.org "Go to composer homepage") [![Made with LARAVEL](https://img.shields.io/badge/laravel-10-red?logo=laravel&logoColor=white)](https://laravel.com "Go to laravel")
Paquete | Version
--- | ---
[Node](https://nodejs.org/en/) | V20.11.0+
[NPM](https://nodejs.org/en/)  | V10.2.4+
[Composer](https://getcomposer.org/)  | V2.6.5+
[PHP](https://www.php.net/)  | V8.2.4+
[Mysql](https://www.mysql.com/)  |V 8.0.27+
 
## Installation
[!IMPORTANT] :warning:Asegurate de cumplir todos los requerimiento antes de ejecutar.:warning:
 
###Para ejecutar el proyecto en local
1. Clonar el repositorio
    ```sh
    git clone https://github.com/D0nP3ngu1n/GestionIncidencias.git
    ```
 
1. Vamos a la carpeta del proyecto
    ```sh
    cd /GestionIncidencias
    ```
 
1. Instalamos las dependencias de `PHP`
    ```sh
    composer install
    ```
1. Instalamos las dependencias de `node`
    ```sh
    npm install
    ```
1. modificamos el fichero `.env` para cumplir con sus parametros
    ``` sh
    #configuracion de la base de datos
    DB_CONNECTION=mysql
    DB_HOST="La IP de su DB"
    DB_PORT=3306
    DB_DATABASE='Nombre de su DB'
    DB_USERNAME='Usuario de DB'
    DB_PASSWORD='Contraseña de DB'
 
    #configuracion del dominio
    LDAP_HOST="La IP de su dominio"
    LDAP_USERNAME="DN"@"CN" #ejemplo:"daw206@iesmhp.local"
    LDAP_PASSWORD="Contraseña del usuario del domniio"
    LDAP_BASE_DN="DN" #ejemplo:"DC=iesmhp,DC=local"
    LDAP_OUS_PERMITIDAS='Ruta de las OU permitidas' #ejemplo: 'OU=AlumnosInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios'
    ```
 
1. Cargar la tablas en la base de datos
    ``` sh
    php artisan migrate:fresh
    ```
1. Cargar los datos en las tablas
    ``` sh
    php artisan db:seed
    ```
 
1. Loguearse con un usuario valido, este usuario se convertira en `Administrador`
   
 
1. Despues de logearse con un usuario, ya se pueden añadir las incidencias de prueba
    ``` sh
    php artisan db:seed --class=IncidenciaSeeder
    ```
 
1. Arrancar el servidor de prueba del Laravel
    ``` sh
    npm run dev & php artisan serve
    ```
---
###Para ejecutar el proyecto en Apache
 
1. Tener ``Apache`` con ``PHP 8.2`` Y ``MYSQL`` instalado.
 
 
1. Clonado del respositorio de github, en la carpeta `/var/www/`.
    ```sh
    git clone https://github.com/D0nP3ngu1n/GestionIncidencias.git
    ```
1. Entramos en la carpeta
    ```sh
    cd /var/www/GestionIncidencias
    ```
1. Instalamos las dependencias de `PHP`
    ```sh
    composer install
    ```
1. Instalamos las dependencias de `node`
    ```sh
    npm install
    ```
1. Hacemos un build
    ```sh
    npm run build
    ```
 
1. Configuracion de permisos
    ```sh
    chown www-data:www-data R public/build
    chmod g+w -R public/build
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    chown -R $USER:www-data storage
    chown -R $USER:www-data bootstrap/cache
    ```
