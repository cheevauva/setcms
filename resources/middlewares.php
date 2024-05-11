<?php

declare(strict_types=1);

return [
    SetCMS\Middleware\ThrowableMiddleware::class,
    SetCMS\Middleware\RouterMiddleware::class,
    SetCMS\Middleware\ParseBodyMiddleware::class,
    SetCMS\Middleware\RetrieveCurrentUserMiddleware::class,
    SetCMS\Middleware\FrontControllerMiddleware::class,
    SetCMS\Middleware\RenderViewMiddleware::class,
];
