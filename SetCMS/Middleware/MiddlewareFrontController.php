<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\Controller\Exception\ControllerEmptyResponseException;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;

class MiddlewareFrontController implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \UUA\Traits\WrappingTrait;
    use \SetCMS\Traits\TraitsRouter;

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routerMatch = $this->router()->match($request->getUri()->getPath(), $request->getMethod());

        $controller = ControllerViaPSR7::as(($routerMatch->target)::new($this->container));
        $controller->name = $routerMatch->name;
        $controller->params = $routerMatch->params;
        $controller->request = $request;

        new ControllerOnBeforeServeEvent($controller)->dispatch($this->eventDispatcher());
        
        $this->wrapping($controller)->serve();

        return $controller->response ?? throw new ControllerEmptyResponseException($routerMatch->target);
    }
}
