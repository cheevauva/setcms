<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

use SetCMS\Contract\ContractNotFound;

class RouterNotFoundException extends RouterException implements ContractNotFound
{

    public function __construct(string $message = 'Маршрут не найден')
    {
        parent::__construct($message);
    }
}
