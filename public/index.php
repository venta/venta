<?php
/*
|--------------------------------------------------------------------------
| Defining constants
|--------------------------------------------------------------------------
|
| Here we define some constants to be used later in application
*/
define('VENTA_START', microtime());
define('VENTA_ROOT', dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Requiring autoloader
|--------------------------------------------------------------------------
|
| Including autoloader
*/
require __DIR__ . '/../bootstrap/autoloader.php';

/*
|--------------------------------------------------------------------------
| Requiring main application class
|--------------------------------------------------------------------------
|
| Including application class initialisation
*/
/** @var \Venta\Contracts\Application\ApplicationContract $app */
$app = require __DIR__ . '/../bootstrap/application.php';

/*
|--------------------------------------------------------------------------
| Getting kernel class
|--------------------------------------------------------------------------
|
| Kernel class is used to handle application flow
*/
/** @var \Venta\Contracts\Kernel\HttpKernelContract $kernel */
$kernel = $app->make(\Venta\Contracts\Kernel\HttpKernelContract::class);

/*
|--------------------------------------------------------------------------
| Handling request
|--------------------------------------------------------------------------
|
| This function call will make application run and handle request object
| producing response object
*/
$response = $kernel->handle($request = new \Venta\Http\Request);

/*
|--------------------------------------------------------------------------
| Output of response
|--------------------------------------------------------------------------
|
| Here is the place response is sent to the browser
*/
$response->send();

/*
|--------------------------------------------------------------------------
| Terminate our application
|--------------------------------------------------------------------------
|
| Termination is called on application here
*/
$kernel->terminate($request, $response);