<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Controller;
use SetCMS\Module\Dynamic\DAO\DynamicMethodRetrieveByServerRequestDAO;
use SetCMS\Controller\Hook\ScopeProtectionHook;

class MiddlewareFrontController implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\EventDispatcherTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $retrieveController = DynamicMethodRetrieveByServerRequestDAO::new($this->container);
        $retrieveController->request = $request;
        $retrieveController->serve();

        $controller = $retrieveController->controller;
        $controller->from($request);
        $controller->from(new Response);

        $event = new ScopeProtectionHook();
        $event->scope = $controller;
        $event->user = $request->getAttribute('currentUser');
        $event->dispatch($this->eventDispatcher());

        $controller->serve();

        $request = $request->withAttribute('output', $controller);

        return $handler->handle($request);
    }
}
