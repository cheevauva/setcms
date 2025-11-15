<?php

declare(strict_types=1);

$middlewares[10] = \SetCMS\Middleware\MiddlewareThrowable::class;
$middlewares[100] = \SetCMS\Middleware\MiddlewareParseBody::class;
$middlewares[1000] = \SetCMS\Middleware\MiddlewareFrontController::class;
