<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\View;
use SetCMS\Responder;
use UUA\Unit;

abstract class ControllerViaPSR7 extends Controller
{

    public ServerRequestInterface $request;
    public protected(set) ResponseInterface $response;

    #[\Override]
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

    /**
     * @return array<string|Unit>
     */
    #[\Override]
    protected function domainUnits(): array
    {
        return [];
    }

    /**
     * @return array<string|Unit>
     */
    #[\Override]
    protected function viewUnits(): array
    {
        return [];
    }
}
