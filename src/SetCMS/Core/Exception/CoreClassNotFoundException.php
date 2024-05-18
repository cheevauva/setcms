<?php

declare(strict_types=1);

namespace SetCMS\Core\Exception;

use SetCMS\Contract\NotFound;

class CoreClassNotFoundException extends CoreException implements NotFound
{

    protected $message = "Контроллер обработчика маршрута не найден";

}
