<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Controller;
use SetCMS\Application\Router\RouterController;
use SetCMS\ResponseCollection;

class MiddlewareFrontController implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\EventDispatcherTrait;

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $routerMatch = RouterController::singleton($this->container)->match($path, $method);

        if (!$routerMatch) {
            return $handler->handle($request);
        }
        
        $responseCollection = new ResponseCollection();
        
        $className = $routerMatch->target;

        $controller = Controller::as($className::new($this->container));
        $controller->request = $request->withAttribute('routerMatch', $routerMatch);
        $controller->responseCollection = $responseCollection;
        $controller->serve();
        
        if ($responseCollection->valid()) {
            return $responseCollection->current();
        }

        return $handler->handle($request->withAttribute('controller', $controller));
    }
}
