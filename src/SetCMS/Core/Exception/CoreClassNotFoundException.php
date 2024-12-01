<?php

declare(strict_types=1);

namespace SetCMS\Core\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class CoreClassNotFoundException extends CoreException implements ContractNotFound
{

    protected $message = "Контроллер обработчика маршрута не найден";

}
