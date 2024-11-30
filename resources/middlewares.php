<?php

declare(strict_types=1);

return [
    SetCMS\Application\Middleware\MiddlewareThrowable::class,
    SetCMS\Application\Middleware\MiddlewareRouter::class,
    SetCMS\Application\Middleware\MiddlewareParseBody::class,
    SetCMS\Application\Middleware\MiddlewareRetrieveCurrentUser::class,
    SetCMS\Application\Middleware\MiddlewareFrontController::class,
    SetCMS\Application\Middleware\MiddlewareRenderView::class,
];
