<?php

use Venta\Framework\Application;
use Venta\Framework\Contracts\ApplicationContract;
use Venta\Framework\Contracts\Kernel\ConsoleKernelContract;
use Venta\Framework\Contracts\Kernel\HttpKernelContract;
use Venta\Framework\Kernel\ConsoleKernel;
use Venta\Framework\Kernel\HttpKernel;
use Venta\Routing\Router;
use Venta\Routing\{RoutesCollector, MiddlewareCollector};

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
        $this->singleton(HttpKernelContract::class, HttpKernel::class);
        $this->singleton(ConsoleKernelContract::class, ConsoleKernel::class);

        $this->singleton(ApplicationContract::class, $this);
        $this->singleton('app', ApplicationContract::class);

        $this->singleton('router', function() {
            return (new Router($this, function(RoutesCollector $collector) {
                $this->callExtensionProvidersMethod('routes', $collector);
            }))->collectMiddlewares(function(MiddlewareCollector $collector){
                $this->callExtensionProvidersMethod('middlewares', $collector);
            });
        });

        $this->singleton(\Zend\Diactoros\Response\EmitterInterface::class, \Zend\Diactoros\Response\SapiEmitter::class);

        $this->singleton(\Whoops\RunInterface::class, function() {
            return (new \Whoops\Run(new \Whoops\Util\SystemFacade))->register();
        });
    }
};