<?php

declare(strict_types=1);

namespace SetCMS;

use SplObjectStorage;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use UUA\Unit;
use UUA\ContainerConstructInterface;
use SetCMS\View;
use SetCMS\Responder;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Validation\Validation;
use SetCMS\Controller\Exception\ControllerUnitMustBeInstanceofUnitException;

abstract class Controller extends Unit implements ContainerConstructInterface
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \UUA\Traits\EnvTrait;

    public ServerRequestInterface $request;
    public protected(set) ResponseInterface $response;
    protected SplObjectStorage $messages;
    protected SplObjectStorage $exceptions;

    protected function catch(\Throwable $object): void
    {
        
    }

    protected function init(): void
    {
        $this->messages = new SplObjectStorage();
        $this->exceptions = new SplObjectStorage();
    }

    protected function process(): void
    {
        
    }

    protected function validation(mixed $data): Validation
    {
        if (!is_array($data)) {
            throw new \Exception('Ожидался array, а пришел ' . gettype($data));
        }

        return new Validation($data, $this->messages);
    }

    public function from(object $object): void
    {
        if ($object instanceof View && $object->response) {
            $this->response = $object->response;
        }

        if ($object instanceof Responder && $object->response) {
            $this->response = $object->response;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof Responder) {
            $object->messages = $this->messages;
        }

        if ($object instanceof View) {
            $object->messages = $this->messages;
        }
    }

    /**
     * @return string[]
     */
    protected function domainUnits(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function viewUnits(): array
    {
        return [];
    }

    #[\Override]
    public function serve(): void
    {
        try {
            $onBeforeServe = new ControllerOnBeforeServeEvent();
            $onBeforeServe->controller = $this;
            $onBeforeServe->request = $this->request;
            $onBeforeServe->dispatch($this->eventDispatcher());

            $this->process();
            $this->multiserveUnits($this->domainUnits());
        } catch (\Throwable $ex) {
            $this->exceptions->attach($ex);
            $this->catch($ex);
        }

        $this->throwUncatchedExceptions();
        $this->multiserveUnits($this->viewUnits(), false);
    }

    protected function throwUncatchedExceptions(): void
    {
        if (!$this->exceptions->valid()) {
            return;
        }

        while ($this->exceptions->valid()) {
            $uncatchedMessage = $this->exceptions->current();

            if (!$this->messages->contains($uncatchedMessage)) {
                throw $uncatchedMessage;
            }

            $this->exceptions->next();
        }
    }

    /**
     * @param array<Unit>|array<int, string> $units
     * @return void
     */
    protected function multiserveUnits(array $units, bool $breakIfMessages = true): void
    {
        if ($breakIfMessages && $this->messages->count()) {
            return;
        }

        foreach ($units as $unit) {
            if (is_string($unit)) {
                $unit = $unit::new($this->container);
            }

            if (!($unit instanceof Unit)) {
                throw new ControllerUnitMustBeInstanceofUnitException($unit);
            }

            $this->to($unit);
            $unit->serve();
            $this->from($unit);

            if ($breakIfMessages && $this->messages->count()) {
                return;
            }
        }
    }
}
