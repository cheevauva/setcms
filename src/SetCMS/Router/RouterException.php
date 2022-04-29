<?php

declare(strict_types=1);

namespace SetCMS\Router;

class RouterException extends \Exception
{

    private const NOT_FOUND_ROUTE_MESSAGE = 'NOT_FOUND_ROUTE';
    private const NOT_FOUND_ROUTE_CODE = 404;

    public static function notFound(): self
    {
        return new static(static::NOT_FOUND_ROUTE_MESSAGE, static::NOT_FOUND_ROUTE_CODE);
    }

}
