<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\FactoryInterface;
use SetCMS\ServantInterface;
use SetCMS\ApplyInterface;
use SetCMS\Controller\Servant\BuildByDynamicAttributeServant;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;
use SetCMS\AttributableInterface;

class ExecuteDynamicControllerServant implements ServantInterface, ApplyInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    public string $className;
    public ?string $section = null;
    public ?string $module = null;
    public string $action;
    public \SplObjectStorage $storage;
    public mixed $mixedValue;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->storage = new \SplObjectStorage();
    }

    public function serve(): void
    {
        $controllerBuilder = BuildByDynamicAttributeServant::factory($this->factory);
        $controllerBuilder->className = $this->className;
        $controllerBuilder->section = $this->section ?? '';
        $controllerBuilder->module = $this->module ?? '';
        $controllerBuilder->action = $this->action;
        $controllerBuilder->serve();

        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[1] ?? null;

        if ($caller && $caller['class'] === get_class($controllerBuilder->controller) && $caller['function'] === $this->action) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::factory($this->factory);
        $methodArgumentsBuilder->apply($controllerBuilder->method);
        $methodArgumentsBuilder->apply($this->storage);
        $methodArgumentsBuilder->serve();

        $mixedValue = $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);

        if ($mixedValue instanceof AttributableInterface) {
            $mixedValue->withAttribute('section', $this->section);
            $mixedValue->withAttribute('module', $this->module);
            $mixedValue->withAttribute('action', $this->action);
        }

        $this->mixedValue = $mixedValue;
    }

    public function apply(object $object): void
    {
        $this->storage->attach($object);
    }

}
