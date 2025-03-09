<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\DAO;


use ReflectionParameter;
use ReflectionMethod;
use SplObjectStorage;
use SetCMS\Module\Dynamic\Exception\DynamicClassNotFoundException;
use SetCMS\Module\Dynamic\Exception\DynamicMethodNotFoundException;

class DynamicMethodRetrieveByMethodNameDAO extends \UUA\DAO
{

    
    

    public string $className;
    public string $methodName;
    public ?SplObjectStorage $context = null;
    public ?ReflectionMethod $reflectionMethod;
    public ?object $reflectionObject;
    public ?array $reflectionArguments;
    //
    private array $contextEntities = [];

    public function serve(): void
    {
        $this->context = $this->context ?? new SplObjectStorage;

        if (!class_exists($this->className, true)) {
            throw new DynamicClassNotFoundException;
        }

        if (!method_exists($this->className, $this->methodName)) {
            throw new DynamicMethodNotFoundException;
        }

        $this->contextEntities = [];

        foreach ($this->context as $enitity) {
            $this->contextEntities[$this->context->getInfo() ?? get_class($enitity)] = $enitity;
        }

        $this->reflectionObject = $this->factory()->make($this->className);
        $this->reflectionMethod = (new \ReflectionClass($this->className))->getMethod($this->methodName);
        $this->reflectionArguments = $this->retrieveArguments($this->reflectionMethod);
    }

    private function retrieveArguments(ReflectionMethod $reflectionMethod): array
    {
        $arguments = [];

        foreach ($reflectionMethod->getParameters() as $parameter) {
            assert($parameter instanceof \ReflectionParameter);

            $arguments[$parameter->getPosition()] = $this->retrieveArgumentByReflectionParameter($parameter);
        }

        return $arguments;
    }

    private function retrieveArgumentByReflectionParameter(ReflectionParameter $parameter): mixed
    {
        if (!$parameter->getType()) {
            return null;
        }

        $type = $parameter->getType()->getName();

        if (!class_exists($type, true) && $parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if (isset($this->contextEntities[$type])) {
            return $this->contextEntities[$type];
        }

        switch ($type) {
            case ContractFactory::class:
                return $this->factory();
            case ContainerInterface::class:
                return $this->container;
            default:
                return $this->factory()->make($type);
        }
    }

}
