<?php

use Abava\Http\Factory\ResponseFactory;
use Abava\Routing\{
    MiddlewareCollector, RoutesCollector
};
use Abava\Routing\Router;
use Venta\Application;
use Venta\Contracts\ApplicationContract;
use Venta\Contracts\Kernel\ConsoleKernelContract;
use Venta\Contracts\Kernel\HttpKernelContract;
use Venta\Kernel\ConsoleKernel;
use Venta\Kernel\HttpKernel;
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

        // Binding Request & Response interfaces and implementations
        // If you want to use your own classes, it's the right place to define them
        $this->singleton(\Abava\Http\Contract\RequestContract::class, \Abava\Http\Request::class);
        $this->singleton(ResponseFactory::class, new ResponseFactory(\Abava\Http\Response::class));

        $this->configureLogging();
        $this->configureRouting();
    }

    /**
     * Helper function, called in order to setup error reporting
     */
    protected function configureErrorReporting()
    {
        $runner = new Run;
        $this->singleton(\Whoops\RunInterface::class, $runner);
        $this->singleton('error_handler', \Whoops\RunInterface::class);

        $runner->pushHandler($this->isCli() ? new PlainTextHandler : new PrettyPageHandler)->register();
    }

    /**
     * Helper function, called to bind everything related to routing
     */
    protected function configureRouting()
    {
        $this->singleton(\Abava\Routing\Contract\RouterContract::class, function () {
            return (new Router($this, new MiddlewareCollector(), function (RoutesCollector $collector) {
                $this->callExtensionProvidersMethod('routes', $collector);
            }))->collectMiddlewares(function(MiddlewareCollector $collector){
                $this->callExtensionProvidersMethod('middlewares', $collector);
            });
        });
        $this->singleton('router', \Abava\Routing\Contract\RouterContract::class);
    }

    /**
     * Helper function, called to to bind PSR-3 Logger
     */
    protected function configureLogging()
    {
        /** @var $this Application */
        $this->singleton(Monolog\Logger::class, function(){
            $logger = new \Monolog\Logger('venta');
            $handler = new \Monolog\Handler\StreamHandler(__DIR__ . '/../storage/logs/app.log');
            $handler->pushProcessor(function($record){
                /** @var \Psr\Http\Message\ServerRequestInterface $request */
                $request = $this->get(\Psr\Http\Message\RequestInterface::class);
                $server = $request->getServerParams();
                $record['extra']['url'] =  $request->getUri()->getPath();
                $record['extra']['http_method'] = $request->getMethod();
                $record['extra']['host'] = $request->getUri()->getHost();
                $record['extra']['referer'] = $request->getHeader('referer');
                $record['extra']['user_agent'] = $request->getHeader('user-agent');
                $record['extra']['ip'] = $server['REMOTE_ADDR'] ?? null;
                return $record;
            });
            $handler->setFormatter(new \Monolog\Formatter\LineFormatter());
            $logger->pushHandler($handler);
            return $logger;
        });
        $this->singleton(\Psr\Log\LoggerInterface::class, \Monolog\Logger::class);
    }

};