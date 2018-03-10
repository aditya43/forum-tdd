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
        /**
         * To share with all views "*"
         */
        // \View::composer('*', function ($view)
        // {
        //     $view->with('channels', \App\Channel::all());
        // });

        /**
         * To share with all views using View::share()
         */
        \View::share('channels', \App\Channel::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
