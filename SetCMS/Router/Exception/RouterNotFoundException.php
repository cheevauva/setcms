<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

class RouterNotFoundException extends RouterException
{

    /**
     * @var string
     */
    protected $message = 'Маршрут не найден';
}
