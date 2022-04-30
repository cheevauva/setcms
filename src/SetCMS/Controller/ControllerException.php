<?php

declare(strict_types=1);

namespace SetCMS\Controller;

class ControllerException extends \Exception
{

    public static function controllerNotFound(string $controller): self
    {
        return new static(sprintf('CONTROLLER %s NOT_FOUND', $controller));
    }

    public static function methodNotFound(string $method): self
    {
        return new static(sprintf('METHOD %s NOT_FOUND', $method));
    }

}
