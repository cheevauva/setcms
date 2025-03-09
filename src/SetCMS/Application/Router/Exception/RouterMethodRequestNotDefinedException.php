<?php

declare(strict_types=1);

namespace SetCMS\Application\Router\Exception;

class RouterMethodRequestNotDefinedException extends RouterException
{

    public function __construct(string $message = 'В обработчике маршрута не указан ожидаемый тип метода запроса')
    {
        parent::__construct($message);
    }
}
