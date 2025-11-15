<?php

declare(strict_types=1);

return [
    //SetCMS\Middleware\MiddlewareThrowable::class,
    SetCMS\Middleware\MiddlewareParseBody::class,
    Module\User\Middleware\UserRetrieveCurrentUserMiddleware::class,
    SetCMS\Middleware\MiddlewareFrontController::class,
];
