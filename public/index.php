<?php
/*
|--------------------------------------------------------------------------
| Requiring auto loader
|--------------------------------------------------------------------------
|
| Including auto loader
*/
require __DIR__ . '/../bootstrap/autoloader.php';

/*
|--------------------------------------------------------------------------
| Requiring main application class
|--------------------------------------------------------------------------
|
| Including application class initialisation
*/
/** @var \Venta\Framework\Application $app */
$app = require __DIR__ . '/../bootstrap/application.php';

/*
|--------------------------------------------------------------------------
| Resolving kernel out of container
|--------------------------------------------------------------------------
|
| Kernel will handle application execution process
*/
/** @var \Venta\Framework\Contracts\Kernel\HttpKernelContract $kernel */
$kernel = $app->make(\Venta\Framework\Contracts\Kernel\HttpKernelContract::class);

/*
|--------------------------------------------------------------------------
| Handling request
|--------------------------------------------------------------------------
|
| This function call will make application run and handle request object
| producing response object
*/
$response = $kernel->handle($request = \Zend\Diactoros\ServerRequestFactory::fromGlobals());

/*
|--------------------------------------------------------------------------
| Output of response
|--------------------------------------------------------------------------
|
| Here is the place response is sent to the browser
*/
$kernel->emit($response);

/*
|--------------------------------------------------------------------------
| Terminate our application
|--------------------------------------------------------------------------
|
| Termination is called on application here
*/
$kernel->terminate($request, $response);