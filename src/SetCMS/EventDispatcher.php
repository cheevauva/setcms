<?php

namespace SetCMS;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use Psr\Container\ContainerInterface;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, array $events = [])
    {
        $this->container = $container;
        
        foreach ($container->get('events') as $event => $eventListeners) {
            foreach ($eventListeners as $priority => $eventListener) {
                $this->addListener($event, $eventListener, 999999 - $priority);
            }
        }
    }

    protected function callListeners(iterable $listeners, string $eventName, object $event)
    {
        $stoppable = $event instanceof StoppableEventInterface;

        foreach ($listeners as $listener) {
            if ($stoppable && $event->isPropagationStopped()) {
                break;
            }
            
            $this->container->get($listener)($event, $eventName, $this);
        }
    }

}
