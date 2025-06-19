<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Responder\ResponderBase;

class MiddlewareThrowable implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $ex) {
            $base = ResponderBase::new($this->container);
            $base->messages = new \SplObjectStorage();
            $base->messages->attach($ex);
            $base->serve();

            return $base->response;
        }
    }
}
