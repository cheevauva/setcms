<?php

declare(strict_types=1);

namespace SetCMS\Application\Router\Exception;

class RouterMethodRequestNotDefinedException extends RouterException
{

    protected $message = "В обработчике маршрута не указан ожидаемый тип метода запроса";

}
