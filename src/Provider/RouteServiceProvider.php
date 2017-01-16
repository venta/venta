<?php declare(strict_types = 1);

namespace App\Provider;

use App\Responder\HomeResponder;
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
        $this->routes()->addRoute(Route::get('/{?username:[a-zA-Z0-9]+}', HomeResponder::class));
    }
}