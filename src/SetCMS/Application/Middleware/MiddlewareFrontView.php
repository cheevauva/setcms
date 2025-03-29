<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Servant\ViewRender;
use SetCMS\Application\Router\RouterView;
use SetCMS\Controller;

class MiddlewareFrontView implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
        $controller = $request->getAttribute('controller');
        $view = null;

        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        $routerMatch = RouterView::singleton($this->container)->match($path, $method);

        if (!$controller && !$routerMatch) {
            return $handler->handle($request);
        }

        if ($routerMatch) {
            $className = $routerMatch->target;

            $view = Controller::as($className::new($this->container));
            $view->from($request->withAttribute('routerMatch', $routerMatch));
            $view->from(new Response);

            if ($controller) {
                $view->from($controller);
            }
        }

        $render = ViewRender::new($this->container);
        $render->request = $request;
        $render->mixedValue = $view ?? $controller;
        $render->serve();

        $response = new Response;
        $response = $response->withHeader('Content-Type', $render->contentType);
        $response->getBody()->write($render->content);

        return $response;
    }
}
