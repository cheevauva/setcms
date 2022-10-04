<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\FactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use SetCMS\Contract\Applicable;
use SetCMS\ServantInterface;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface
{

    private FactoryInterface $factory;

    public function __construct(ContainerInterface $container, FactoryInterface $factory)
    {
        $this->factory = $factory;

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

            $listenerObject = $this->factory->make($listener);

            if ($listenerObject instanceof Applicable) {
                $listenerObject->apply($event);
            }

            if ($listenerObject instanceof ServantInterface) {
                $listenerObject->serve();
            } else {
                $this->factory->make($listener)($event, $eventName, $this);
            }
        }
    }

}
