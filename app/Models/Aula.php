<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $table = "aulas";
    public $timestamps = false;

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'aula_num', 'num');
    }
}