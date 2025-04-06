<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\View;
use SetCMS\Responder;

abstract class ControllerViaPSR7 extends Controller
{

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

        if ($object instanceof View && $object->response) {
            $this->response = $object->response;
        }

        if ($object instanceof Responder && $object->response) {
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
}
