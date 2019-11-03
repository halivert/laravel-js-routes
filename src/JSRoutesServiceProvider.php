<?php

namespace Hali\JSRoutes;

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
