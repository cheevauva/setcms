<?php

declare(strict_types=1);

namespace SetCMS;

use UUA\UnitInterface;
use UUA\SymbiontCustomizer;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;

    protected array $listeners = [];

    #[\Override]
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        foreach ($container->get('events') as $event => $eventListeners) {
            foreach ($eventListeners as $priority => $eventListener) {
                $this->listeners[$event][999999 - $priority] = $eventListener;
            }
        }
    }

    protected function callListeners(iterable $listeners, string $eventName, object $event): void
    {
        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }

            $unit = $listener[0]::new($this->container);

            if (!($unit instanceof UnitInterface)) {
                throw new \Exception(sprintf('Обработчик "%s" для события "%s" должен имплементировать UnitInterface', $listener[0], $eventName));
            }

            $symbiont = isset($listener[1]) ? new $listener[1]($event) : null;

            if ($symbiont instanceof SymbiontCustomizer) {
                $symbiont->to($unit);
            }

            $unit->serve();

            if ($symbiont instanceof SymbiontCustomizer) {
                $symbiont->from($unit);
            }
        }
    }

    public static function instance(): self
    {
        return static::$instance;
    }

    #[\Override]
    public function dispatch(object $event): object
    {
        $this->callListeners($this->listeners[get_class($event)], get_class($event), $event);
        
        return $event;
    }
}
