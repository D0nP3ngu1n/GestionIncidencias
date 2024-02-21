<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $table = "perfiles";
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personal_id', 'id');
    }
}
