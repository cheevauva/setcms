<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Exception;

class DynamicMethodNotFoundException extends DynamicClassNotFoundException
{

    protected $message = "Метод обработчик маршрута не найден";

}
