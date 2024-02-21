<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    protected $table = "incidencias";
    public $timestamps = false;

    /**
     * Relacion uno a uno entre subtipo e incidendia
     * @param null no recibe parametros
     * @return
     */
    public function subtipo()
    {
        return $this->belongsTo(IncidenciaSubtipo::class, 'subtipo_id', 'id');
    }
}
