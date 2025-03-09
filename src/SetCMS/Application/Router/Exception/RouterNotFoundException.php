<?php

declare(strict_types=1);

namespace SetCMS\Application\Router\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class RouterNotFoundException extends RouterException implements ContractNotFound
{

    public function __construct(string $message = 'Маршрут не найден')
    {
        parent::__construct($message);
    }

}
