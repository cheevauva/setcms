<?php

declare(strict_types=1);

namespace SetCMS;

use SplObjectStorage;
use UUA\Unit;
use UUA\ContainerConstructInterface;
use SetCMS\Validation\Validation;
use SetCMS\Controller\Exception\ControllerUnitMustBeInstanceofUnitException;

abstract class Controller extends Unit implements ContainerConstructInterface
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \UUA\Traits\EnvTrait;

    public array $ctx = [];
    protected SplObjectStorage $messages;
    protected SplObjectStorage $exceptions;

    abstract protected function process(): void;

    protected function init(): void
    {
        $this->messages = new SplObjectStorage();
        $this->exceptions = new SplObjectStorage();
    }

    protected function validation(mixed $data): Validation
    {
        if (!is_array($data)) {
            throw new \Exception('Ожидался array, а пришел ' . gettype($data));
        }

        return new Validation($data, $this->messages);
    }

    public function from(object $object): void
    {
        
    }

    public function to(object $object): void
    {
        
    }

    protected function catch(\Throwable $object): void
    {
        
    }

    /**
     * @return string[]
     */
    protected function domainUnits(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function viewUnits(): array
    {
        return [];
    }

    #[\Override]
    public function serve(): void
    {
        try {
            $this->onBeforeServe();
            $this->process();
            $this->multiserveUnits($this->domainUnits());
        } catch (\Throwable $ex) {
            $this->exceptions->attach($ex);
            $this->catch($ex);
        }

        $this->throwUncatchedExceptions();
        $this->multiserveUnits($this->viewUnits(), false);
    }

    protected function onBeforeServe(): void
    {
        
    }

    protected function throwUncatchedExceptions(): void
    {
        if (!$this->exceptions->valid()) {
            return;
        }

        while ($this->exceptions->valid()) {
            $uncatchedMessage = $this->exceptions->current();

            if (!$this->messages->contains($uncatchedMessage)) {
                throw $uncatchedMessage;
            }

            $this->exceptions->next();
        }
    }

    /**
     * @param array<Unit>|array<int, string> $units
     * @return void
     */
    protected function multiserveUnits(array $units, bool $breakIfMessages = true): void
    {
        if ($breakIfMessages && $this->messages->count()) {
            return;
        }

        foreach ($units as $unit) {
            if (is_string($unit)) {
                $unit = $unit::new($this->container);
            }

            if (!($unit instanceof Unit)) {
                throw new ControllerUnitMustBeInstanceofUnitException(sprintf('%s должен быть наследником %s', get_class($unit), Unit::class));
            }

            $this->to($unit);
            $unit->serve();
            $this->from($unit);

            if ($breakIfMessages && $this->messages->count()) {
                return;
            }
        }
    }
}
