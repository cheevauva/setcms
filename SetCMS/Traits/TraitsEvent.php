<?php

namespace SetCMS\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;

trait TraitsEvent
{

    public function dispatch(EventDispatcherInterface $dispatcher): void
    {
        $dispatcher->dispatch($this);
    }
}
