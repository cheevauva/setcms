<?php

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;

enum RequestAttribute: string
{

    case accessToken = 'X-CSRF-Token';
    case currentUser = 'currentUser';

    public function fromRequest(ServerRequestInterface $request): mixed
    {
        return $request->getAttribute($this->value);
    }

    public function toRequest(ServerRequestInterface $request, mixed $value): ServerRequestInterface
    {
        return $request->withAttribute($this->value, $value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
