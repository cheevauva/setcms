<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use SplObjectStorage;
use UUA\Unit;
use UUA\ContainerConstructInterface;
use SetCMS\Contract\ContractObjectInteraction;
use SetCMS\Controller\Exception\ControllerUnitMustBeInstanceofUnitException;

abstract class Controller extends Unit implements ContainerConstructInterface, ContractObjectInteraction
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \UUA\Traits\EnvTrait;
    use \UUA\Traits\WrappingTrait;

    public string $name;

    /**
     * @var array<string, mixed>
     */
    public array $params = [];
    public protected(set) bool $hasACLCheck = true;

    /**
     * @var array<string, mixed|object>
     */
    public array $ctx = [];

    /**
     * @var SplObjectStorage<\Throwable|object, mixed>
     */
    protected SplObjectStorage $messages;

    /**
     * @var SplObjectStorage<\Throwable, mixed>
     */
    protected SplObjectStorage $exceptions;

    abstract protected function process(): void;

    #[\Override]
    public function from(object $object): void
    {
        
    }

    #[\Override]
    public function to(object $object): void
    {
        
    }

    protected function catch(\Throwable $object): void
    {
        
    }

    /**
     * @return class-string[]
     */
    protected function domainUnits(): array
    {
        return [];
    }

    /**
     * @return class-string[]
     */
    protected function viewUnits(): array
    {
        return [];
    }

    #[\Override]
    public function serve(): void
    {
        $this->messages = new SplObjectStorage();
        $this->exceptions = new SplObjectStorage();

        $domainUnits = $this->overrideDomainUnits($this->domainUnits());
        $viewUnits = $this->overrideViewUnits($this->viewUnits());

        try {
            $this->onBeforeProcess();
            $this->process();
            $this->runUnits($domainUnits, $this->stopRunningDomainUnits(...));
        } catch (\Throwable $ex) {
            $this->exceptions->attach($ex);
            $this->catch($ex);
        }

        $this->throwUncatchedExceptions();
        $this->runUnits($viewUnits, $this->stopRunningViewUnits(...));
    }

    protected function onBeforeProcess(): void
    {
        
    }

    /**
     * @param class-string[] $domainUnits
     * @return class-string[]
     */
    protected function overrideDomainUnits(array $domainUnits): array
    {
        return $domainUnits;
    }

    /**
     * @param class-string[] $viewUnits
     * @return class-string[]
     */
    protected function overrideViewUnits(array $viewUnits): array
    {
        return $viewUnits;
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

    protected function stopRunningDomainUnits(): bool
    {
        return $this->messages->count() !== 0;
    }

    protected function stopRunningViewUnits(): bool
    {
        return false;
    }

    /**
     * @param array<Unit>|array<int, class-string> $units
     * @return void
     */
    protected function runUnits(array $units, \Closure $stopRunningUnits): void
    {
        foreach ($units as $unit) {
            if (($stopRunningUnits)()) {
                return;
            }
            
            if (is_string($unit)) {
                $unit = $unit::new($this->container);
            }

            if (!($unit instanceof Unit)) {
                throw new ControllerUnitMustBeInstanceofUnitException(sprintf('%s должен быть наследником %s', get_class($unit), Unit::class));
            }

            $this->to($unit);
            $this->wrapping($unit)->serve();
            $this->from($unit);
        }
    }
}
