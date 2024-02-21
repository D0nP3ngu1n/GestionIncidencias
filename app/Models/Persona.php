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
     * Relacion uno a muchos entre departamento y persona
     * @param null no recibe parametros
     * @return
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    /**
     * Relacion uno a uno entre persona y perfil
     * @param null no recibe parametros
     * @return
     */
    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'personal_id', 'id');
    }
}
