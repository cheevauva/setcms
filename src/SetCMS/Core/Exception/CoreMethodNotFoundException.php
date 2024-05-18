<?php

declare(strict_types=1);

namespace SetCMS\Core\Exception;

class CoreMethodNotFoundException extends CoreClassNotFoundException
{

    protected $message = "Метод обработчик маршрута не найден";

}
