<?php

use App\Kernel;
use Psr\Http\Message\ServerRequestInterface;
use Venta\Framework\Http\HttpApplication;
use Venta\Http\Factory\RequestFactory;

require __DIR__ . '/../bootstrap/autoloader.php';

/** @var \Venta\Framework\Http\HttpApplication $app */
$app = new HttpApplication(new Kernel);

/** @var ServerRequestInterface $request */
$request = (new RequestFactory)->createServerRequestFromGlobals();

$app->run($request);