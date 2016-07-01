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

// todo Move to kernel?
// todo Overwrite with Venta factory ?
$server  = \Zend\Diactoros\ServerRequestFactory::normalizeServer($_SERVER);
$headers = \Zend\Diactoros\ServerRequestFactory::marshalHeaders($server);
$request =
    new \Venta\Framework\Http\Request($server, \Zend\Diactoros\ServerRequestFactory::normalizeFiles($_FILES),
        \Zend\Diactoros\ServerRequestFactory::marshalUriFromServer($server, $headers),
        \Zend\Diactoros\ServerRequestFactory::get('REQUEST_METHOD', $server, 'GET'), 'php://input', $headers, $_COOKIE,
        $_GET, $_POST// todo add protocol marshalling
    );
/*
|--------------------------------------------------------------------------
| Handling request
|--------------------------------------------------------------------------
|
| This function call will make application run and handle request object
| producing response object
*/
$response = $kernel->handle($request);

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