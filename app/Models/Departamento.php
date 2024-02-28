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
     * Relacion uno a muchos entre departamento y usuario
     * @param null no recibe parametros
     * @return
     */
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}