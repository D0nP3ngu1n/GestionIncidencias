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
        return $this->belongsTo(Persona::class, 'responsable_id');
    }

    /**
     * Relacion uno a muchos entre incidencia y comentarios
     * @param none no recibe parametros
     * @return
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'incidencia_num');
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
