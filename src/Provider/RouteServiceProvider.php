<?php declare(strict_types = 1);

namespace App\Provider;

use App\Responder\HomeResponder;
use Venta\Contracts\Routing\MutableRouteCollection;
use Venta\Routing\Route;
use Venta\ServiceProvider\AbstractServiceProvider;

/**
 * Class RouteServiceProvider
 *
 * @package App\Provider
 */
class RouteServiceProvider extends AbstractServiceProvider
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        /** @var MutableRouteCollection $routes */
        $routes = $this->container->get(MutableRouteCollection::class);
        $routes->addRoute(Route::get('/[{username:alphanum}]', HomeResponder::class));
    }
}