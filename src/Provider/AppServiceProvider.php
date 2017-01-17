<?php declare(strict_types = 1);

namespace App\Provider;

use Venta\Contracts\Container\MutableContainer;
use Venta\ServiceProvider\AbstractServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Provider
 */
class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * @inheritdoc
     */
    public function bind(MutableContainer $container)
    {
        // Add service container bindings here...
    }
}