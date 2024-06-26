<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

use SetCMS\Contract\NotFound;

class RouterNotFoundException extends RouterException implements NotFound
{

    protected $message = "Маршрут не найден";

}
