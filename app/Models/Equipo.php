<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $table = "equipos";
    public $timestamps = false;

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_num', 'num');
    }
}