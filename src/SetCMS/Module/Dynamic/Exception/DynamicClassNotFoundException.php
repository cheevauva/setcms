<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class DynamicClassNotFoundException extends DynamicException implements ContractNotFound
{

    protected $message = "Контроллер обработчика маршрута не найден";

}
