<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\setRolesToUserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot()
{
    //esto hace que la paginacion haga uso del css de bootstrap
     Paginator::useBootstrap();
    // Establecer una vista personalizada para los enlaces de paginación
    //Paginator::defaultSimpleView('pagination.default');
}
}
