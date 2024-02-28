<?php

namespace App\Models;

// Importaciones necesarias
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, AuthenticatesWithLdap, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        // No incluyas 'password' aquí si las contraseñas se manejan completamente a través de LDAP.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password', // Puedes comentar o eliminar esta línea si las contraseñas no se almacenan localmente.
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

// Métodos adicionales requeridos por LdapAuthenticatable, si es necesario.

    /**
     * Relacion uno a muchos entre persona (creador) e incidencias
     * @param null no recibe parametros
     * @return
     */
    public function incidenciasCreadas()
    {
        return $this->hasMany(Incidencia::class, 'creador_id');
    }

    /**
     * Relacion uno a muchos entre persona (responsable) e incidencias
     * @param null no recibe parametros
     * @return
     */
    public function incidenciasResponsable()
    {
        return $this->hasMany(Incidencia::class, 'responsable_id');
    }

    /**
     * Relacion uno a muchos entre persona y comentarios
     * @param null no recibe parametros
     * @return
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'personal_id');
    }


    public function departamento()
    {
        return $this->belongsTo(Departamento::class,'departamento_id','id');
    }
}
