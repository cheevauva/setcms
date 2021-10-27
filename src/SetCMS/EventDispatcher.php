<?php

namespace SetCMS;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use Psr\Container\ContainerInterface;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface
{

    public function __construct(ContainerInterface $container, array $events = [])
    {
        foreach ($container->get('events') as $event => $eventListeners) {
            foreach ($eventListeners as $priority => $eventListener) {
                $this->addListener($event, $container->get($eventListener), 999999 - $priority);
            }
        }
    }

}
