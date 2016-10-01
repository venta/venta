<?php declare(strict_types = 1);

namespace App\Provider;

use App\Action\HomeAction;
use Venta\Contracts\Routing\RouteCollector;
use Venta\Routing\RouteBuilder;
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
    public function boot()
    {
        $routes = $this->container->get(RouteCollector::class);
        $routes->add(RouteBuilder::get('/', HomeAction::class)->build());
    }
}