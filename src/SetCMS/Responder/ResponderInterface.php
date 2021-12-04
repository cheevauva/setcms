<?php

namespace SetCMS\Responder;

use Psr\Http\Message\ResponseInterface as Response;

interface ResponderInterface
{

    public function apply(object $object): ResponderInterface;

    public function prepareResponse(Response $response): Response;
}
