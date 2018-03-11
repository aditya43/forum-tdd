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
        \View::composer('*', function ($view)
        {
            $channels = \Illuminate\Support\Facades\Cache::rememberForever('channels', function ()
            {
                return \App\Channel::all();
            });

            $view->with('channels', $channels);
        });

        /**
         * To share with all views using View::share()
         */
        // \View::share('channels', \App\Channel::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal())
        {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
