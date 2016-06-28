<?php

use Venta\Framework\Application;
use Venta\Framework\Contracts\ApplicationContract;
use Venta\Routing\Router;
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
        $this->singleton('app', ApplicationContract::class);

        $this->singleton('router', function() {
            return (new Router($this))->collectRoutes(function(RoutesCollector $collector) {
                $this->callExtensionProvidersMethod('routes', $collector);
            });
        });

        $this->singleton(\Zend\Diactoros\Response\EmitterInterface::class, \Zend\Diactoros\Response\SapiEmitter::class);
    }
};