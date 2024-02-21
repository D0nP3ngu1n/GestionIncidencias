<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $table = "departamentos";
    public $timestamps = false;

    /**
     * Relacion uno a muchos entre departamento y persona
     * @param null no recibe parametros
     * @return
     */
    public function personas()
    {
        return $this->hasMany(Persona::class, 'jefedep_id', 'id');
    }
}
