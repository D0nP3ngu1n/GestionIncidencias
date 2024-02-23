<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = "personal";
    public $timestamps = false;



    /**
     * Relacion uno a uno entre persona y perfil
     * @param null no recibe parametros
     * @return
     */
    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'personal_id', 'id');
    }

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
}
