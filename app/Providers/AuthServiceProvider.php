<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use LdapRecord\Laravel\Auth\BindFailureListener;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
       /* Autenticacion del LDAP*/
       $this->registerPolicies();

        Fortify::authenticateUsing(function ($request) {
            $validated = Auth::validate([
                'samaccountname' => $request->username,
                'password' => $request->password
            ]);

            return $validated ? Auth::getLastAttempted() : null;
        });

        BindFailureListener::setErrorHandler(function ($message, $code = null) {
            if ($code == '773') {
                // The users password has expired. Redirect them.
                abort(redirect('/password-reset'));
            }
        });
    }
}
