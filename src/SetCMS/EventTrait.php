<?php

namespace SetCMS;

trait EventTrait
{

    public function dispatch(object $dispatcher): self
    {
        if ($dispatcher instanceof \Psr\EventDispatcher\EventDispatcherInterface) {
            $dispatcher->dispatch($this);
        }

        return $this;
    }

}
