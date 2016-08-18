<?php

use Abava\Container\Contract\Container as ContainerContract;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Venta\Kernel;

/*
|--------------------------------------------------------------------------
| Creating and returning main application class
|--------------------------------------------------------------------------
*/
return new class(new \Abava\Container\Container(), realpath(__DIR__ . '/../')) extends Kernel
{
    /**
     * @inheritDoc
     */
    public function boot(): ContainerContract
    {
        /** @var Kernel $this */
        /*
         * Binding Abava/Http request implementation to PSR-6 interface
         */
        $this->container->singleton(ServerRequestInterface::class, function () {
            return (new \Abava\Http\Factory\RequestFactory())->createServerRequestFromGlobals();
        });

        /*
         * Binding Response factory contract to Abava implementation
         */
        $this->container->singleton(
            \Abava\Http\Contract\ResponseFactory::class,
            \Abava\Http\Factory\ResponseFactory::class
        );

        /**
         * Binding console input and output to default implementations
         */
        $this->container->singleton(InputInterface::class, function () {
            return new ArgvInput();
        });
        $this->container->singleton(OutputInterface::class, function () {
            return new ConsoleOutput();
        });

        return parent::boot();
    }

};