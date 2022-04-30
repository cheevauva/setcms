<?php

namespace SetCMS;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Container\ContainerInterface;
use DI\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface
{

    private FactoryInterface $factory;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);

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

            $this->factory->make($listener)($event, $eventName, $this);
        }
    }

}
