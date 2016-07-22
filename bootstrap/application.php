<?php

use Abava\Container\Contract\Caller;
use Abava\Container\Contract\Container;
use Abava\Http\Factory\ResponseFactory;
use Venta\Application;
use Venta\Contracts\Application as ApplicationContract;
use Venta\Contracts\Kernel\ConsoleKernel as ConsoleKernelContract;
use Venta\Contracts\Kernel\HttpKernel as HttpKernelContract;
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
     * This method is called in both cli and http mods
     *
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->configureErrorReporting();

        $this->singleton(HttpKernelContract::class, HttpKernel::class);
        $this->singleton(ConsoleKernelContract::class, ConsoleKernel::class);

        $this->singleton(ApplicationContract::class, $this);
        $this->singleton('app', ApplicationContract::class);
        $this->singleton(Container::class, $this);
        $this->singleton(Caller::class, $this);

        // Binding Request & Response interfaces and implementations
        // If you want to use your own classes, it's the right place to define them
        $this->singleton(\Abava\Http\Contract\Request::class, $this->createServerRequest());
        $this->singleton(ResponseFactory::class, $this->createResponseFactory());

        $this->configureLogging();
        $this->bindRouting();
    }

    /**
     * Helper function, called in order to setup error reporting
     */
    protected function configureErrorReporting()
    {
        $runner = new Run;
        $this->singleton(\Whoops\RunInterface::class, $runner);
        $this->singleton('error_handler', \Whoops\RunInterface::class);

        if ($this->isCli()) {
            // Console kernel will render exception
            $runner->allowQuit(false);
            $runner->sendHttpCode(false);
            $runner->writeToOutput(false);
        } else {
            // Enable pretty error page for local environment only
            $runner->pushHandler($this->isLocalEnvironment() ? new PrettyPageHandler : new PlainTextHandler);
        }
        $runner->register();
    }

    /**
     * Helper function, called to to bind PSR-3 Logger
     */
    protected function configureLogging()
    {
        /** @var $this Application */
        $this->singleton(Monolog\Logger::class, function () {
            $logger = new \Monolog\Logger('venta');
            $handler = new \Monolog\Handler\StreamHandler(__DIR__ . '/../storage/logs/app.log');
            $handler->pushProcessor(function ($record) {
                if ($this->has('request')) {
                    // Add HTTP request related extra info

                    /** @var \Psr\Http\Message\ServerRequestInterface $request */
                    $request = $this->get('request');
                    $server = $request->getServerParams();
                    $record['extra']['url'] = $request->getUri()->getPath();
                    $record['extra']['http_method'] = $request->getMethod();
                    $record['extra']['host'] = $request->getUri()->getHost();
                    $record['extra']['referer'] = $request->getHeader('referer');
                    $record['extra']['user_agent'] = $request->getHeader('user-agent');
                    $record['extra']['ip'] = $server['REMOTE_ADDR'] ?? null;
                } elseif ($this->has('input')) {
                    // Add cli command related extra info

                    /** @var \Symfony\Component\Console\Input\InputInterface $input */
                    $input = $this->get('input');
                    $record['extra']['command'] = $input->getFirstArgument();
                    $record['extra']['arguments'] = $input->getArguments();
                    $record['extra']['options'] = $input->getOptions();
                }
                return $record;
            });
            $handler->setFormatter(new \Monolog\Formatter\LineFormatter());
            $logger->pushHandler($handler);
            return $logger;
        });
        $this->singleton(\Psr\Log\LoggerInterface::class, \Monolog\Logger::class);
    }

};