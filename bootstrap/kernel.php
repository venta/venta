<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Venta\Contracts\Container\Container;
use Venta\Contracts\Http\Request;
use Venta\Framework\Kernel;
use Venta\Http\Factory\RequestFactory;

/*
|--------------------------------------------------------------------------
| Creating and returning main application class
|--------------------------------------------------------------------------
*/
return new class(new \Venta\Container\Container(), realpath(__DIR__ . '/../')) extends Kernel
{
    /**
     * @inheritDoc
     */
    public function boot(): Container
    {
        /** @var Kernel $this */
        /*
         * Binding Abava/Http request implementation to PSR-6 interface
         */
        $this->container->share(ServerRequestInterface::class, function () {
            return (new RequestFactory())->createServerRequestFromGlobals();
        }, ['request', RequestInterface::class, Request::class]);

        /*
         * Binding Response factory contract to Abava implementation
         */
        $this->container->share(
            Venta\Contracts\Http\ResponseFactory::class,
            Venta\Http\Factory\ResponseFactory::class
        );

        /**
         * Binding console input and output to default implementations
         */
        $this->container->share(InputInterface::class, function () {
            return new ArgvInput();
        }, ['input']);
        $this->container->share(OutputInterface::class, function () {
            return new ConsoleOutput();
        }, ['output']);

        return parent::boot();
    }

};