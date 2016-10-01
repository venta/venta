<?php

use App\Provider\AppServiceProvider;
use Venta\Framework\ErrorHandler\ErrorHandlerProvider;
use Venta\Framework\Extension\VentaServiceProvider;

return [
    'providers' => [
        VentaServiceProvider::class,
        ErrorHandlerProvider::class,
        AppServiceProvider::class,
    ],
];