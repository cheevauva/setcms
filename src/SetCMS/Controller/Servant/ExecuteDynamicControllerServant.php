<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\FactoryInterface;
use SetCMS\ServantInterface;
use SetCMS\ApplyInterface;
use SetCMS\Controller\Servant\BuildByDynamicAttributeServant;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;

class ExecuteDynamicControllerServant implements ServantInterface, ApplyInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    public string $className = 'SetCMS\Module\{module}\{module}{section}Controller';
    public ?string $module = null;
    public ?string $action = null;
    public ?string $section = null;
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
        $controllerBuilder->action = $this->action ?? '';
        $controllerBuilder->serve();

        $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::factory($this->factory);

        foreach ($this->storage as $object) {
            $methodArgumentsBuilder->apply($object);
        }

        $methodArgumentsBuilder->apply($controllerBuilder->method);
        $methodArgumentsBuilder->serve();

        $this->mixedValue = $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);
    }

    public function apply(object $object): void
    {
        $this->storage->attach($object);
    }

}
