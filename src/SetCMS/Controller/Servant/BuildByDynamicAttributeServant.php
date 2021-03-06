<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\ServantInterface;
use SetCMS\Controller\ControllerException;
use SetCMS\FactoryInterface;

class BuildByDynamicAttributeServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    public string $className;
    public string $module;
    public string $section;
    public string $action;
    public object $controller;
    public \ReflectionMethod $method;

    public function __construct(FactoryInterface $factory)
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
