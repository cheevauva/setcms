<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\ServantInterface;
use SetCMS\Controller\ControllerException;

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
        $controllerClassName = sprintf('SetCMS\Module\%s\%s%sController', ucfirst($this->module), ucfirst($this->module), $this->section);

        if (!class_exists($controllerClassName, true)) {
            throw ControllerException::controllerNotFound($controllerClassName);
        }

        if (!method_exists($controllerClassName, $this->action)) {
            $controllerShortName = (new \ReflectionClass($controllerClassName))->getShortName();
            throw ControllerException::methodNotFound(sprintf('%s::%s', $controllerShortName, $this->action));
        }

        $this->controller = new $controllerClassName;
        $this->method = (new \ReflectionClass($controllerClassName))->getMethod($this->action);
    }

}
