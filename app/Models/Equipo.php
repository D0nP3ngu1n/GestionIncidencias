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
