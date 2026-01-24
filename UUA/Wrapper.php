<?php

declare(strict_types=1);

namespace UUA;

abstract class Wrapper extends Unit
{

    use Traits\ContainerTrait;
    use Traits\BuildTrait;

    public Unit $rootUnit;
    public Unit $nextUnit;

    #[\Override]
    public function serve(): void
    {
        $this->onBefore();
        $this->nextUnit->serve();
        $this->onAfter();
    }

    abstract protected function onBefore(): void;

    abstract protected function onAfter(): void;

    public function from(object $object): void
    {
        
    }
}
