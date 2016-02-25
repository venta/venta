<?php

/*
|--------------------------------------------------------------------------
| Creating main application class
|--------------------------------------------------------------------------
|
| Place to update text
|
*/
$app = new \Venta\Application\Application(VENTA_ROOT);

/*
|--------------------------------------------------------------------------
| Binding kernel implementations
|--------------------------------------------------------------------------
|
| We bind both Http/Console kernels.
| Also, we do pass in application interface implementation
| as a parameter to inject it into constructor
|
*/
$app->share(
    \Venta\Application\Interfaces\HttpKernelInterface::class,
    \Venta\Application\Kernel\HttpKernel::class
);

$app->share(
    \Venta\Application\Interfaces\ConsoleKernelInterface::class,
    \Venta\Application\Kernel\ConsoleKernel::class
);

return $app;