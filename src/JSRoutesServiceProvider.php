<?php

namespace Halivert\JSRoutes;

use Illuminate\Support\ServiceProvider;

class JSRoutesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            Console\CreateJSRoutesCommand::class
        ]);
    }
}
