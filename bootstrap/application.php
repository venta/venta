<?php

use Venta\Framework\Application;
use Venta\Framework\Contracts\ApplicationContract;
use Venta\Framework\Contracts\Kernel\ConsoleKernelContract;
use Venta\Framework\Contracts\Kernel\HttpKernelContract;
use Venta\Framework\Kernel\ConsoleKernel;
use Venta\Framework\Kernel\HttpKernel;
use Venta\Routing\Router;
use Venta\Routing\{RoutesCollector, MiddlewareCollector};
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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
        $this->configureErrorReporting();

        $this->singleton(HttpKernelContract::class, HttpKernel::class);
        $this->singleton(ConsoleKernelContract::class, ConsoleKernel::class);

        $this->singleton(ApplicationContract::class, $this);
        $this->singleton('app', ApplicationContract::class);

        $this->configureRouting();
    }

    /**
     * Helper function, called in order to setup error reporting
     */
    protected function configureErrorReporting()
    {
        $runner = new Run;
        $this->singleton(\Whoops\RunInterface::class, $runner);
        $this->singleton('errors_handler', \Whoops\RunInterface::class);

        $this->callExtensionProvidersMethod('errors', $runner);

        if (count($runner->getHandlers()) === 0) {
            $handler = $this->isCli() ? new PlainTextHandler : new PrettyPageHandler;
            $runner->pushHandler($handler);
        }

        $runner->unregister();
        $runner->register();
    }

    /**
     * Helper function, called to bind everything related to routing
     */
    protected function configureRouting()
    {
        $this->singleton(\Venta\Routing\Contract\RouterContract::class, function () {
            return (new Router($this, new MiddlewareCollector(), function (RoutesCollector $collector) {
                $this->callExtensionProvidersMethod('routes', $collector);
            }))->collectMiddlewares(function(MiddlewareCollector $collector){
                $this->callExtensionProvidersMethod('middlewares', $collector);
            });
        });
        $this->singleton('router', \Venta\Routing\Contract\RouterContract::class);
    }
};