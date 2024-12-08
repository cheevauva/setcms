<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\Application\Contract\ContractFactory;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use Psr\EventDispatcher\StoppableEventInterface;
use SetCMS\Application\Contract\ContractApplicable;
use SetCMS\Application\Contract\ContractServant;

class EventDispatcher extends SymfonyEventDispatcher implements EventDispatcherInterface
{

    use \SetCMS\Traits\AsTrait;

    private ContractFactory $factory;
    private static EventDispatcher $instance;

    public function __construct(ContainerInterface $container, ContractFactory $factory)
    {
        $this->factory = $factory;

        foreach ($container->get('events') as $event => $eventListeners) {
            foreach ($eventListeners as $priority => $eventListener) {
                $this->addListener($event, [$eventListener], 999999 - $priority);
            }
        }
    }

    #[\Override]
    protected function callListeners(iterable $listeners, string $eventName, object $event): void
    {
        $stoppable = $event instanceof StoppableEventInterface;

        foreach ($listeners as $listener) {
            $listener = $listener[0];

            if ($stoppable && $event->isPropagationStopped()) {
                break;
            }

            $listenerObject = $this->factory->make($listener);

            if ($listenerObject instanceof ContractApplicable) {
                $listenerObject->from($event);
            }

            if ($listenerObject instanceof ContractServant) {
                $listenerObject->serve();
            } else {
                $this->factory->make($listener)($event, $eventName, $this);
            }

            if ($listenerObject instanceof ContractApplicable) {
                $listenerObject->to($event);
            }
        }
    }

    public static function instance(): self
    {
        return static::$instance;
    }
}
