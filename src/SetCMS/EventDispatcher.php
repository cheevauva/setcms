<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\Contract\Factory;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use SetCMS\Contract\Applicable;
use SetCMS\Contract\Servant;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface
{

    use AsTrait;

    private Factory $factory;
    private static EventDispatcher $instance;

    public function __construct(ContainerInterface $container, Factory $factory)
    {
        static::$instance = $this;

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
                $listenerObject->from($event);
            }

            if ($listenerObject instanceof Servant) {
                $listenerObject->serve();
            } else {
                $this->factory->make($listener)($event, $eventName, $this);
            }

            if ($listenerObject instanceof Applicable) {
                $listenerObject->to($event);
            }
        }
    }

    public static function instance(): self
    {
        return static::$instance;
    }

}
