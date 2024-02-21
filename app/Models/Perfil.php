<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $table = "perfiles";
    public $timestamps = false;

    /**
     * Relacion uno a uno entre persona y perfil
     * @param null no recibe parametros
     * @return
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personal_id', 'id');
    }
}
