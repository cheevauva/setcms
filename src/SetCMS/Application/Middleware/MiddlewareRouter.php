<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Application\Router\Router;

class MiddlewareRouter implements MiddlewareInterface, \UUA\ContainerConstructInterface
{
    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routerMatch = Router::new($this->container)->match(...[
            $request->getUri()->getPath(),
            $request->getMethod()
        ]);

        foreach ($routerMatch->params as $pName => $pValue) {
            $request = $request->withAttribute($pName, $pValue);
        }

        $request = $request->withAttribute('routeTarget', $routerMatch->target);

        return $handler->handle($request);
    }
}
