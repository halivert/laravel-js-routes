<?php

namespace Halivert\JSRoutes\Tests\Stubs\Providers;

use Halivert\JSRoutes\JSRoutesServiceProvider;
use Illuminate\Support\AggregateServiceProvider;

class JSRoutesServiceTestProvider extends AggregateServiceProvider
{
    protected $providers = [
        JSRoutesServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->app['service.loaded'] = true;
    }
}
