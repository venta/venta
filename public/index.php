<?php

use App\Kernel;
use Psr\Http\Message\ServerRequestInterface;
use Venta\Http\Factory\RequestFactory;
use Venta\Http\HttpApplication;

require __DIR__ . '/../bootstrap/autoloader.php';

/** @var HttpApplication $app */
$app = new HttpApplication(new Kernel());

/** @var ServerRequestInterface $request */
$request = (new RequestFactory())->createServerRequestFromGlobals();

$app->run($request);