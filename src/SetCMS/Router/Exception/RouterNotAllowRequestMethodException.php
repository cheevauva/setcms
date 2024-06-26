<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

class RouterNotAllowRequestMethodException extends RouterException implements \SetCMS\Contract\NotAllow
{

    protected $message = "Метод запроса для данного маршрута не разрешен";

}
