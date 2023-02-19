<?php

namespace SetCMS;

use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\EventDispatcher;

trait EventTrait
{

    public function dispatch(?object $dispatcher = null): self
    {
        if (is_null($dispatcher)) {
            $dispatcher = EventDispatcher::instance();
        }

        if ($dispatcher instanceof EventDispatcherInterface) {
            $dispatcher->dispatch($this);
        }

        return $this;
    }

    public function __invoke()
    {
        $this->dispatch();
    }

}
