<?php

namespace SetCMS\Core;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventTrait
{

    public function dispatch(EventDispatcherInterface $dispatcher): self
    {
        return $dispatcher->dispatch($this);
    }

}
