<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Controller;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Application\Router\RouterController;
use SetCMS\Application\Router\Exception\RouterNotFoundException;

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
            throw new RouterNotFoundException(sprintf('%s %s', $method, $path));
        }
        
        $className = $routerMatch->target;

        $controller = Controller::as($className::new($this->container));
        $controller->from($request->withAttribute('routerMatch', $routerMatch));
        $controller->from(new Response);

        $event = new ScopeProtectionHook();
        $event->scope = $controller;
        $event->user = $request->getAttribute('currentUser');
        $event->dispatch($this->eventDispatcher());

        $controller->serve();

        return $handler->handle($request->withAttribute('controller', $controller));
    }
}
