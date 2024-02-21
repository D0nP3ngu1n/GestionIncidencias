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
