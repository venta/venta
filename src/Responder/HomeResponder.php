<?php declare(strict_types = 1);

namespace App\Responder;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Venta\Adr\AbstractResponder;
use Venta\Contracts\Adr\Payload;

/**
 * Class HomeResponder
 *
 * @package App\Responder
 */
class HomeResponder extends AbstractResponder
{
    /**
     * @inheritDoc
     */
    public function run(ServerRequestInterface $request, Payload $payload = null): ResponseInterface
    {
        $username = $request->getAttribute('route')->variables()['username'] ?? '';
        if ($username) {
            return $this->html("Hi there, $username. I'm Venta");
        }

        return $this->html('Hi there. I\'m Venta');
    }
}