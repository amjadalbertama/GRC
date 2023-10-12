<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
    public function boot(\App\Library\GroupPermissions $userdata)
    {
        //
        Blade::if('permission', function ($value) use ($userdata) {
            return ($userdata->hasPermission($value));
        });

        Blade::if('inAllPermission', function($value) use ($userdata){
            
            foreach($value as $val) {
                if (! $userdata->hasPermission($val)) {
                    return false;
                }
            }

            return true;
        });

        Blade::if('hasSomePermission', function($value) use ($userdata){
            
            $r = 1;
            foreach($value as $val) {
                if (! $userdata->hasPermission($val)) {
                    $r += 0;
                } else {
                    $r += 1;
                }
            }

            return $r;
        });
    }
}
