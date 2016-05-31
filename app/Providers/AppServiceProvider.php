<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register Contracts
        $this->app->bind('App\Contracts\Repositories\UntappdUserRepositoryContract', 'App\Repositories\UntappdUserRepository');
        $this->app->bind('App\Contracts\Repositories\UntappdCheckinRepositoryContract', 'App\Repositories\UntappdCheckinRepository');
    }
}
