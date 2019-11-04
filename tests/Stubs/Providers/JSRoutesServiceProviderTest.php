<?php

namespace Halivert\JSRoutes\Tests\Stubs\Providers;

use Halivert\JSRoutes\JSRoutesServiceProvider;
use Illuminate\Support\AggregateServiceProvider;

class JSRoutesServiceProviderTest extends AggregateServiceProvider
{
    protected $providers = [
        JSRoutesServiceProvider::class,
    ];

    public function register()
    {
        parent::register();

        $this->app['service.loaded'] = true;
    }
}
