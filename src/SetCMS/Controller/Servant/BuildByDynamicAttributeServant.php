<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Controller\ControllerException;
use SetCMS\Contract\Factory;

class BuildByDynamicAttributeServant implements Servant
{

    use \SetCMS\FactoryTrait;

    private Factory $factory;
    public string $className;
    public string $module;
    public string $section;
    public string $action;
    public object $controller;
    public \ReflectionMethod $method;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }
    
    public function serve(): void
    {
        $controllerClassName = strtr($this->className, [
            '{module}' => ucfirst($this->module),
            '{section}' => ucfirst($this->section),
        ]);

        if (!class_exists($controllerClassName, true)) {
            throw ControllerException::controllerNotFound($controllerClassName);
        }

        if (!method_exists($controllerClassName, $this->action)) {
            $controllerShortName = (new \ReflectionClass($controllerClassName))->getShortName();
            throw ControllerException::methodNotFound(sprintf('%s::%s', $controllerShortName, $this->action));
        }

        $this->controller = $this->factory->make($controllerClassName);
        $this->method = (new \ReflectionClass($controllerClassName))->getMethod($this->action);
    }

}
