<?php

namespace SetCMS\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventTrait
{

    public function dispatch(EventDispatcherInterface $dispatcher): void
    {
        $dispatcher->dispatch($this);
    }
}
