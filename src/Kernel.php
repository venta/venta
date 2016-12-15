<?php declare(strict_types = 1);

namespace App;

use App\Provider\AppServiceProvider;
use App\Provider\RouteServiceProvider;
use Venta\Framework\Kernel\AbstractKernel;
use Venta\Framework\ServiceProvider\CacheServiceProvider;
use Venta\Framework\ServiceProvider\ConsoleServiceProvider;
use Venta\Framework\ServiceProvider\EventServiceProvider;
use Venta\Framework\ServiceProvider\HttpServiceProvider;
use Venta\Framework\ServiceProvider\RoutingServiceProvider;

/**
 * Class Kernel
 *
 * @package App
 */
class Kernel extends AbstractKernel
{
    /**
     * @inheritDoc
     */
    public function rootPath(): string
    {
        return realpath(__DIR__ . '/../');
    }

    /**
     * @inheritDoc
     */
    protected function registerServiceProviders(): array
    {
        return [
            // Framework Providers
            HttpServiceProvider::class,
            RoutingServiceProvider::class,
            ConsoleServiceProvider::class,
            EventServiceProvider::class,
            CacheServiceProvider::class,

            // Application Providers
            AppServiceProvider::class,
            RouteServiceProvider::class,
        ];
    }
}