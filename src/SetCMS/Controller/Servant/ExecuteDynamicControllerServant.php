<?php

declare(strict_types=1);

namespace SetCMS\Controller\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Controller\Servant\BuildByDynamicAttributeServant;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;

class ExecuteDynamicControllerServant implements Servant, Applicable
{

    use \SetCMS\FactoryTrait;
    use \SetCMS\DITrait;

    public string $className;
    public ?string $section = null;
    public ?string $module = null;
    public string $action;
    public \SplObjectStorage $storage;
    public mixed $mixedValue;

    private function storage(): \SplObjectStorage
    {
        $this->storage = $this->storage ?? new \SplObjectStorage();

        return $this->storage;
    }

    public function serve(): void
    {
        $controllerBuilder = BuildByDynamicAttributeServant::make($this->factory());
        $controllerBuilder->className = $this->className;
        $controllerBuilder->section = $this->section ?? '';
        $controllerBuilder->module = $this->module ?? '';
        $controllerBuilder->action = $this->action;
        $controllerBuilder->serve();

        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[1] ?? null;

        if ($caller && $caller['class'] === get_class($controllerBuilder->controller) && $caller['function'] === $this->action) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::make($this->factory());
        $methodArgumentsBuilder->apply($controllerBuilder->method);
        $methodArgumentsBuilder->apply($this->storage());
        $methodArgumentsBuilder->serve();

        $this->mixedValue = $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);
    }

    public function apply(object $object): void
    {
        $this->storage()->attach($object);
    }

}
