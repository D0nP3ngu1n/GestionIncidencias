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
