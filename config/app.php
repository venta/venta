<?php

use Venta\Framework\Middleware\AddCookieToResponse;

return [
    'name' => 'Venta',
    'log_level' => 'debug',
    'middlewares' => [
        AddCookieToResponse::class,
    ],
];