<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = "personal";
    public $timestamps = false;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }
    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'personal_id', 'id');
    }
}
