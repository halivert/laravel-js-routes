<?php

namespace Hali\CreateJSRoutes;

use Illuminate\Support\ServiceProvider;

class CreateJSRoutesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            Console\CreateJSRoutesCommand::class
        ]);
    }
}
