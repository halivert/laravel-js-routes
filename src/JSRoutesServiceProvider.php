<?php

namespace Halivert\JSRoutes;

use Illuminate\Support\ServiceProvider;

class JSRoutesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/jsroutes.php', 'jsroutes');
    }

    public function register()
    {
        $this->commands([
            Console\CreateJSRoutesCommand::class
        ]);
    }
}
