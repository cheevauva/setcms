<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\ServantInterface;
use SetCMS\FactoryInterface;

class BuildByTargetStringServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    public string $target;
    public object $controller;
    public \ReflectionMethod $method;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function serve(): void
    {
        list($controllerClassName, $methodName) = explode('::', $this->target, 2);

        if (!class_exists($controllerClassName, true)) {
            throw new \Exception($controllerClassName);
        }

        if (!method_exists($controllerClassName, $methodName)) {
            throw new \Exception($methodName);
        }

        $this->controller = $this->factory->make($controllerClassName);
        $this->method = (new \ReflectionClass($controllerClassName))->getMethod($methodName);
    }

}
