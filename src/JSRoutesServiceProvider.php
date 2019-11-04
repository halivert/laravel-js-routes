<?php

namespace Halivert\JSRoutes;

use Illuminate\Support\ServiceProvider;

class JSRoutesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/jsroutes.php', 'jsroutes');

        $this->commands([
            Console\CreateJSRoutesCommand::class
        ]);
    }
}
