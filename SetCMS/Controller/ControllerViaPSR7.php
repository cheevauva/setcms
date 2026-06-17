<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\View\View;
use SetCMS\Responder;
use SetCMS\View\ViewJsonErrorHandler;
use SetCMS\View\ViewHtmlErrorHandler;
use SetCMS\Mapper\MapperFromRequest;

abstract class ControllerViaPSR7 extends Controller
{

    public ServerRequestInterface $request;
    public protected(set) ?ResponseInterface $response = null;

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof View) {
            $this->response = $object->response;
        }

        if ($object instanceof Responder) {
            $this->response = $object->response;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MapperFromRequest) {
            $object->request = $this->request;
            $object->params = $this->params;
            $object->messages = $this->messages;
        }

        if ($object instanceof Responder) {
            $object->request = $this->request;
            $object->messages = $this->messages;
        }

        if ($object instanceof View) {
            $object->request = $this->request;
            $object->messages = $this->messages;
        }
    }

    #[\Override]
    protected function stopRunningViewUnits(): bool
    {
        if (isset($this->response)) {
            return true;
        }

        return parent::stopRunningViewUnits();
    }

    #[\Override]
    protected function overrideViewUnits(array $viewUnits): array
    {
        array_unshift($viewUnits, $this->errorHandlerView());

        return $viewUnits;
    }

    /**
     * @return class-string
     */
    protected function errorHandlerView(): string
    {
        if (str_contains($this->request->getHeaderLine('Accept'), 'json')) {
            return ViewJsonErrorHandler::class;
        }

        return ViewHtmlErrorHandler::class;
    }
}
