<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "comentarios";
    public $timestamps = false;
/**
     * Funcion para sacar el tiempo que ha pasado desde que se ha creado el comentario
     * @param none no recibe parametros
     * @return
     */
    public function getFecha(){
        $fechaFormateada = Carbon::parse($this->fechahora);
        return $fechaFormateada->diffInDays(Carbon::now());
    }


    /**
     * Relacion uno a muchos entre persona y comentarios
     * @param none no recibe parametros
     * @return
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id','id');
    }

    /**
     * Relacion uno a muchos entre incidencia y comentarios
     * @param none no recibe parametros
     * @return
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'id');
    }
}
