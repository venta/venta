<?php declare(strict_types = 1);

namespace App;

use App\Provider\AppServiceProvider;
use Venta\Framework\Kernel\AbstractKernel;
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
    public function getRootPath(): string
    {
        return realpath(__DIR__ . '/../');
    }

    /**
     * @inheritDoc
     */
    protected function registerServiceProviders(): array
    {
        return [
            HttpServiceProvider::class,
            RoutingServiceProvider::class,
            ConsoleServiceProvider::class,
            EventServiceProvider::class,

            AppServiceProvider::class,
        ];
    }


}