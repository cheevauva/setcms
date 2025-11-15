<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

use SetCMS\Exception;

class RouterException extends Exception
{

    public function __construct(string $message = 'Исключительная ситуация при обработке маршрута')
    {
        parent::__construct($message);
    }
}
