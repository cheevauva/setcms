<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\View;
use SetCMS\Responder;
use UUA\Unit;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Application\Router\RouterMatchDTO;

abstract class ControllerViaPSR7 extends Controller
{

    public protected(set) bool $hasACLCheck = true;
    public ServerRequestInterface $request;
    public protected(set) ResponseInterface $response;

    #[\Override]
    protected function process(): void
    {
        // use $this->validate($this->request->getParsedBody() ?: [])
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof View && isset($object->response)) {
            $this->response = $object->response;
        }

        if ($object instanceof Responder && isset($object->response)) {
            $this->response = $object->response;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Responder) {
            $object->ctx = $this->ctx;
            $object->messages = $this->messages;
        }

        if ($object instanceof View) {
            $object->ctx = $this->ctx;
            $object->messages = $this->messages;
        }
    }

    #[\Override]
    protected function onBeforeServe(): void
    {
        $onBeforeServe = new ControllerOnBeforeServeEvent();
        $onBeforeServe->controller = $this;
        $onBeforeServe->request = $this->request;
        $onBeforeServe->route = RouterMatchDTO::as($this->ctx['routerMatch'])->name;
        $onBeforeServe->dispatch($this->eventDispatcher());
    }

    /**
     * @return array<string|Unit>
     */
    protected function domainUnits(): array
    {
        return [];
    }

    /**
     * @return array<string|Unit>
     */
    protected function viewUnits(): array
    {
        return [];
    }
}
