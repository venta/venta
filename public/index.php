<?php
/*
|--------------------------------------------------------------------------
| Defining constants
|--------------------------------------------------------------------------
|
| Here we define some constants to be used later in application
*/
define('VENTA_START', microtime());

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
$app = require __DIR__ . '/../bootstrap/application.php';

/*
|--------------------------------------------------------------------------
| Handling request
|--------------------------------------------------------------------------
|
| This function call will make application run and handle request object
| producing response object
*/
/** @var \Psr\Http\Message\ResponseInterface $response */
$response = $app->run($request = \Zend\Diactoros\ServerRequestFactory::fromGlobals());

/*
|--------------------------------------------------------------------------
| Output of response
|--------------------------------------------------------------------------
|
| Here is the place response is sent to the browser
*/
echo $response->getBody();

/*
|--------------------------------------------------------------------------
| Terminate our application
|--------------------------------------------------------------------------
|
| Termination is called on application here
*/
$app->terminate($request, $response);