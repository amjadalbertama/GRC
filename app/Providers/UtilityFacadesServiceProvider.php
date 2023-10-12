<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Facades\Utility;

class UtilityFacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind('utility', function(){
            return new Utility;
        });
    }
}
