<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * In questo modo possiamo ritornara alla view 'layouts.app' dei dati ogni volta che viene inclusa.
         *
        View::composer('layouts.app', function ( \Illuminate\View\View $view){
            $notifications = [];
            return $view->with('layoutNotifications', $notifications);
        });
        */
    }
}
