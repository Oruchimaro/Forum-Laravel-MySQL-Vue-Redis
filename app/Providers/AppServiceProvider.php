<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        //Doc6
        // \View::share('channels', \App\Channel::all());
        /**Instead of using above code we will use the below one
         * because it wont start the query until the view is loaded
         */
        \View::composer('*', function ($view){
            $view->with('channels', \App\Channel::all());
        });
    }
}
