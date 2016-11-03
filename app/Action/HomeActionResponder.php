<?php declare(strict_types = 1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Venta\Contracts\Adr\Payload;
use Venta\Contracts\Adr\Responder;
use Venta\Contracts\Http\ResponseFactory;

/**
 * Class HomeAction
 *
 * @package App\Controller
 */
class HomeActionResponder implements Responder
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * HomeAction constructor.
     *
     * @param ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @inheritDoc
     */
    public function run(ServerRequestInterface $request, Payload $payload = null): ResponseInterface
    {
        return $this->responseFactory->createResponse()->append('Hi there. I\'m Venta');
    }
}