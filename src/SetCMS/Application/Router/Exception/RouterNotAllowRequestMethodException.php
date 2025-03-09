<?php

declare(strict_types=1);

namespace SetCMS\Application\Router\Exception;

class RouterNotAllowRequestMethodException extends RouterException implements \SetCMS\Application\Contract\ContractNotAllow
{

    public function __construct(string $message = 'Метод запроса для данного маршрута не разрешен')
    {
        parent::__construct($message);
    }

}
