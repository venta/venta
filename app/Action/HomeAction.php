<?php declare(strict_types = 1);

namespace App\Action;

use Venta\Contracts\Http\ResponseFactory;

/**
 * Class HomeAction
 *
 * @package App\Controller
 */
class HomeAction
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
     * @return string
     */
    public function __invoke()
    {
        return $this->responseFactory->createResponse()->append('Hi there. I\'m Venta');
    }
}