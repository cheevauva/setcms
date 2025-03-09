<?php

declare(strict_types=1);

namespace UUA\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventTrait
{

    public function dispatch(EventDispatcherInterface $eventDispatcher): void
    {
        $eventDispatcher->dispatch($this);
    }
}
