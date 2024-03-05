<?php

namespace App\Models;

// Importaciones necesarias
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use PDOException;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens, HasRoles, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, AuthenticatesWithLdap;

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

    // funcion para sacar su rol
    /**
     * @param none
     * @return string retorna una cadena con el rol que tiene el usuario
     */
    public function getRol()
    {

        $rol = DB::table('roles')
            ->where('id', function ($query) {
                $query->select('role_id')
                    ->from('model_has_roles')
                    ->where('model_id', $this->id);
            })
            ->pluck('name')
            ->first();

        return $rol;
    }

    /**
     * @param int $nuevoRol , ID del rol que quieres poner al usuario
     * @return mixed 1 si es correcto redirect si es fallo
     */
    public function setRol($nuevoRol){
        try{
            return DB::table('model_has_roles')
            ->where('model_id', $this->id)
            ->update(['role_id' => $nuevoRol]);
        }catch(PDOException $e){
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el actualizar el rol');
        }
    }

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
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

        /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
