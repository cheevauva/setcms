<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Core\ServantInterface;
use SetCMS\Core\Controller;
use SetCMS\Core\ApplyInterface;
use SetCMS\Exception\ControllerNotFound;
use SetCMS\Exception\MethodNotFound;

class BuildControllerWithReflectionMethodServant implements ServantInterface, ApplyInterface
{

    public string $module;
    public string $section;
    public string $action;
    public Controller $controller;
    public \ReflectionMethod $method;

    public function serve(): void
    {
        $controllerClassName = sprintf('SetCMS\Module\%s\%s%sController', $this->module, $this->module, $this->section);

        if (!class_exists($controllerClassName, true)) {
            throw new ControllerNotFound($controllerClassName);
        }

        if (!method_exists($controllerClassName, $this->action)) {
            throw new MethodNotFound($this->action);
        }

        $this->controller = new $controllerClassName;
        $this->method = (new \ReflectionClass($controllerClassName))->getMethod($this->action);
    }

    public function apply(object $object): void
    {
        if ($object instanceof ApplyInterface) {
            $object->apply($this);
        }
    }

}
