<?php

declare(strict_types=1);

namespace SetCMS\Request\Mapper;

use SplObjectStorage;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Validation\Validation;
use SetCMS\Router\RouterRouteDTO;

abstract class RequestMapper extends \UUA\Mapper
{

    use \SetCMS\Traits\TraitsValidation;

    /**
     * @var SplObjectStorage<\Throwable|object, mixed>
     */
    public SplObjectStorage $messages;
    public ServerRequestInterface $request;

    protected function validationBody(): Validation
    {
        $body = $this->request->getParsedBody() ?: [];

        if (!is_array($body)) {
            throw new \Exception('body must be array');
        }

        return $this->validation($body);
    }

    protected function validationParams(): Validation
    {
        return $this->validation(RouterRouteDTO::fromRequest($this->request)->params);
    }

    protected function validationQuery(): Validation
    {
        return $this->validation($this->request->getQueryParams());
    }

    protected function validationAttributes(): Validation
    {
        return $this->validation($this->request->getAttributes());
    }

    protected function validationHeaders(): Validation
    {
        $headers = [];

        foreach ($this->request->getHeaders() as $name => $values) {
            $headers[$name] = implode(', ', $values);
        }

        return $this->validation($headers);
    }

    protected function validationCookie(): Validation
    {
        return $this->validation($this->request->getCookieParams());
    }
}
