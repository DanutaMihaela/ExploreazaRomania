<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;
use Auth;
use Log;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        view()->composer(['*'], function ($view){
            if (Auth::guard('host')->check()) {
                View::share([
                    'user' => Auth::guard('host')->user(),
                    'userType' => 'host'
                ]);
            }
            if (Auth::guard('tourist')->check()) {
                View::share([
                    'user' => Auth::guard('tourist')->user(),
                    'userType' => 'tourist'
                ]);
            }
        });

    }
}