<?php declare(strict_types = 1);

use App\Kernel;
use Psr\Http\Message\ServerRequestInterface;
use Venta\Contracts\Http\ResponseEmitter;
use Venta\Http\HttpApplication;

require __DIR__ . '/../bootstrap/autoloader.php';

$app = new HttpApplication(new Kernel);

/** @var ServerRequestInterface $request */
$request = $app->getContainer()->get(ServerRequestInterface::class);

$response = $app->run($request);
$app->getContainer()->get(ResponseEmitter::class)->emit($response);