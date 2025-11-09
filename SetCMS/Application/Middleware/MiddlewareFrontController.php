<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\ControllerViaPSR7;
use SetCMS\Application\Router\Router;
use SetCMS\View\ViewNoContent;
use SetCMS\View\ViewNotFound;

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

        $routerMatch = Router::singleton($this->container)->match($path, $method);

        if (!$routerMatch) {
            $notFound = ViewNotFound::new($this->container);
            $notFound->message = 'Маршрут не найден';
            $notFound->serve();

            return $notFound->response;
        }

        $ctx = $request->getAttributes();

        $className = $routerMatch->target;

        $controller = ControllerViaPSR7::as($className::new($this->container));
        $controller->name = $routerMatch->name;
        $controller->params = $routerMatch->params;
        $controller->request = $request;
        $controller->ctx = $ctx;
        $controller->serve();

        if (!isset($controller->response)) {
            $noContent = ViewNoContent::new($this->container);
            $noContent->serve();

            return $noContent->response;
        }

        return $controller->response;
    }
}
