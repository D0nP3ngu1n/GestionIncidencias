<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $table = "aulas";

    protected $primaryKey = 'num';
    public $timestamps = false;

    /**
     * Relacion uno a muchos entre aula y equipos
     * @param null no recibe parametros
     * @return
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'aula_num', 'num');
    }
}
