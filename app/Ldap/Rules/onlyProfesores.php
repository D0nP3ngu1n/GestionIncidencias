<?php

namespace App\Ldap\Rules;

use Illuminate\Database\Eloquent\Model as Eloquent;
use LdapRecord\Laravel\Auth\Rule;
use LdapRecord\Models\Model as LdapRecord;

class onlyProfesores implements Rule
{
    /**
     * Check if the rule passes validation.
     */
    public function passes(LdapRecord $user, Eloquent $model = null): bool
    {
        // Ejemplos DN
        //CN=DAW206,OU=DAW2,OU=AlumnosInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local
        //CN=Carmen Iza Castanedo,OU=ProfesoresInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local

        // Obtener la base DN desde el archivo .env -> LDAP_BASE_DN
        $baseDN = env('LDAP_BASE_DN');

        // Obtener las OUs permitidas desde el archivo .env -> LDAP_OUS_PERMITIDAS
        $ousPermitidas = explode('|', env('LDAP_OUS_PERMITIDAS'));

        // Array con OUs permitidas para pruebas rápidas
        /*$ousPermitidas = [
        ];*/

        // Comprobar si el atributo distinguishedname contiene alguna de las OUs permitidas
        foreach ($ousPermitidas as $ouPermitida) {
            // Construir el DN completo concatenando la OU permitida con la base DN
            $dnCompleto = $ouPermitida . ',' . $baseDN;

            // Comprobar si el DN completo está el el distinguishedname del usuario
            if (strpos($user->getFirstAttribute('distinguishedname'), $dnCompleto ) !== false) {
                // Puede hacer login
                return true;
            }
        }

        // No puede hacer login
        return true;
    }
}
