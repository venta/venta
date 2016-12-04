<?php declare(strict_types = 1);

namespace App\Responder;

use Venta\Adr\AbstractResponder;
use Venta\Contracts\Adr\Payload;
use Venta\Contracts\Http\Request;
use Venta\Contracts\Http\Response;

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
    public function run(Request $request, Payload $payload = null): Response
    {
        $username = $request->getRoute()->getVariables()['username'] ?? '';
        if ($username) {
            return $this->html("Hi there, $username. I'm Venta");
        }
        return $this->html('Hi there. I\'m Venta');
    }
}