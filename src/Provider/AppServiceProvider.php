<?php declare(strict_types = 1);

namespace App\Provider;

use App\Responder\HomeResponder;
use Venta\Contracts\Routing\RouteCollection;
use Venta\Routing\Route;
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
        /** @var RouteCollection $routes */
        $routes = $this->container->get(RouteCollection::class);
        $routes->addRoute(Route::get('/', HomeResponder::class));
    }
}