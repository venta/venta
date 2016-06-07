<?php

use Venta\Framework\Application;
use Venta\Framework\Contracts\ApplicationContract;
use Venta\Routing\RoutesCollector;

/*
|--------------------------------------------------------------------------
| Creating and returning main application class
|--------------------------------------------------------------------------
*/
return new class(realpath(__DIR__ . '/../')) extends Application
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->singleton(ApplicationContract::class, $this);

        $this->singleton('router', function() {
            return \Venta\Routing\createRouter(function(RoutesCollector $collector) {
                $this->callExtensionProvidersMethod('routes', $collector);
            });
        });
    }
};