<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Servant\ViewRender;

class MiddlewareRenderView implements MiddlewareInterface
{

    use \SetCMS\Traits\DITrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $output = $request->getAttribute('output');

        if ($output instanceof ResponseInterface) {
            $request = $output;
        } else {
            $response = new Response;
        }

        if (is_null($output)) {
            $response->getBody()->write('Success!');
        } else {
            $render = ViewRender::make($this->factory());
            $render->request = $request;
            $render->mixedValue = $output;
            $render->serve();

            $response = $response->withHeader('Content-Type', $render->contentType);
            $response->getBody()->write($render->content);
        }

        return $response;
    }
}
