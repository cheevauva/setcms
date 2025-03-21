<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Servant\ViewRender;

class MiddlewareFrontView implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $controller = $request->getAttribute('controller');

        if ($controller instanceof ResponseInterface) {
            $request = $controller;
        } else {
            $response = new Response;
        }

        if (is_null($controller)) {
            $response->getBody()->write('Success!');
        } else {
            $render = ViewRender::new($this->container);
            $render->request = $request;
            $render->mixedValue = $controller;
            $render->serve();

            $response = $response->withHeader('Content-Type', $render->contentType);
            $response->getBody()->write($render->content);
        }

        return $response;
    }
}
