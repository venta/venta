<?php

use Venta\Framework\Application;
use Venta\Framework\Contracts\ApplicationContract;
use Venta\Framework\Contracts\Kernel\ConsoleKernelContract;
use Venta\Framework\Contracts\Kernel\HttpKernelContract;
use Venta\Framework\Http\Factory\ResponseFactory;
use Venta\Framework\Kernel\ConsoleKernel;
use Venta\Framework\Kernel\HttpKernel;
use Venta\Routing\{
    MiddlewareCollector, RoutesCollector
};
use Venta\Routing\Router;
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
        $this->singleton(\Psr\Http\Message\RequestInterface::class, \Venta\Http\Request::class);
        $this->singleton(ResponseFactory::class, new ResponseFactory(\Venta\Http\Response::class));

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
        $this->singleton(\Venta\Routing\Contract\RouterContract::class, function () {
            return (new Router($this, new MiddlewareCollector(), function (RoutesCollector $collector) {
                $this->callExtensionProvidersMethod('routes', $collector);
            }))->collectMiddlewares(function(MiddlewareCollector $collector){
                $this->callExtensionProvidersMethod('middlewares', $collector);
            });
        });
        $this->singleton('router', \Venta\Routing\Contract\RouterContract::class);
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