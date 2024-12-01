<?php

declare(strict_types=1);

namespace SetCMS\Application\Router\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class RouterNotFoundException extends RouterException implements ContractNotFound
{

    protected $message = "Маршрут не найден";

}
