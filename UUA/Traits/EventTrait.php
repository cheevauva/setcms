<?php

declare(strict_types=1);

namespace UUA\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventTrait
{

    use AsTrait;

    public function dispatch(EventDispatcherInterface $eventDispatcher): void
    {
        $eventDispatcher->dispatch($this);
    }
}
