<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "comentarios";
    public $timestamps = false;

    /**
     * Relacion uno a muchos entre persona y comentarios
     * @param null no recibe parametros
     * @return
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personal_id');
    }

    /**
     * Relacion uno a muchos entre incidencia y comentarios
     * @param null no recibe parametros
     * @return
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_num');
    }
}
