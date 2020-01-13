<?php

namespace App\Providers;

use App\Channel;
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
        \View::composer('*', function ($view) {

            //$view->with('channels', \App\Channel::all());

            $channels = \Cache::rememberForever('channels', function () {

                return Channel::all();
            });

            $view->with('channels', $channels);
        });

        //This is needed for laravel to find this custom rule.
        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
