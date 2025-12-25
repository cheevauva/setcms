<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

class RouterRouteByNameNotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Не найден маршрут по имени';
}
