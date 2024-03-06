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
        DB::unprepared('
            CREATE EVENT IF NOT EXISTS cerrarIncidenciasEvent
            ON SCHEDULE EVERY 1 DAY
            STARTS CURRENT_DATE + INTERVAL 23 HOUR + INTERVAL 59 MINUTE
            ON COMPLETION PRESERVE
            DO CALL cerrarIncidenciasResueltas();
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP EVENT IF EXISTS cerrarIncidenciasEvent;');
    }
};
