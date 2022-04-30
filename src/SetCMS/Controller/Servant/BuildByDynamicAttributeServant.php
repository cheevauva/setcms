<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\Core\ServantInterface;
use SetCMS\Exception\ControllerNotFound;
use SetCMS\Exception\MethodNotFound;

class BuildByDynamicAttributeServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    public string $module;
    public string $section;
    public string $action;
    public object $controller;
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

}
