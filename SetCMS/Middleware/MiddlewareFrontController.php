<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\Controller\Exception\ControllerEmptyResponseException;

class MiddlewareFrontController implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \SetCMS\Traits\TraitsRouter;

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $this->router()->match($request->getUri()->getPath(), $request->getMethod());

        $controller = ControllerViaPSR7::as(($route->target)::new($this->container));
        $controller->request = $request->withAttribute('route', $route);
        $controller->serve();

        return $controller->response ?? throw new ControllerEmptyResponseException($route->target);
    }
}
