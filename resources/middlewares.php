<?php

declare(strict_types=1);

return [
    SetCMS\Application\Middleware\MiddlewareParseBody::class,
    SetCMS\Module\User\Middleware\UserRetrieveCurrentUserMiddleware::class,
    SetCMS\Application\Middleware\MiddlewareFrontController::class,
    SetCMS\Application\Middleware\MiddlewareFrontView::class,
    SetCMS\Application\Middleware\MiddlewareNotFound::class,
];
