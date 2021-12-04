<?php

namespace SetCMS\Responder;

use Psr\Http\Message\ResponseInterface as Response;

abstract class Responder implements ResponderInterface
{

    use ResponderApplyTrait;

    abstract protected function getContentType(): string;

    abstract protected function getContent(): string;

    public function prepareResponse(Response $response): Response
    {
        $response = $response->withHeader('Content-type', $this->getContentType());
        $response->getBody()->write((string) $this->getContent());

        return $response;
    }

}
