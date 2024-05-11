<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Router\Router;

class RouterMiddleware implements MiddlewareInterface
{
    use \SetCMS\DITrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routerMatch = Router::make($this->factory())->match(...[
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
