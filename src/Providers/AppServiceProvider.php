<?php

namespace Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
            __DIR__ . '/../views/' => resource_path('views'),

        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("Admin\Repositories\Contracts\AdminInterface",'Admin\Repositories\Eloquent\AdminRepository');
        $this->app->bind("Admin\Repositories\Contracts\RouteInterface",'Admin\Repositories\Eloquent\RouteRepository');
        $this->app->bind("Admin\Repositories\Contracts\RoleInterface",'Admin\Repositories\Eloquent\RoleRepository');
        $this->app->bind("Admin\Repositories\Contracts\RoleRouteInterface",'Admin\Repositories\Eloquent\RoleRouteRepository');
    }
}