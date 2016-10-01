<?php declare(strict_types = 1);

namespace App\Action;

/**
 * Class HomeAction
 *
 * @package App\Controller
 */
class HomeAction
{
    /**
     * @return string
     */
    public function __invoke()
    {
        return 'Hi there. I\'m Venta';
    }
}