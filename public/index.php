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
| Requiring kernel
|--------------------------------------------------------------------------
|
| Includes kernel class initialisation
*/
/** @var \Venta\Contract\Kernel $kernel */
$kernel = require __DIR__ . '/../bootstrap/kernel.php';

/*
|--------------------------------------------------------------------------
| Creating HTTP Application
|--------------------------------------------------------------------------
|
| Initializes application and boots kernel
*/
$app = new \Venta\Application\HttpApplication($kernel);

/*
|--------------------------------------------------------------------------
| Running Application
|--------------------------------------------------------------------------
|
| Application handles HTTP request, creates and emits HTTP response
*/
$app->run();