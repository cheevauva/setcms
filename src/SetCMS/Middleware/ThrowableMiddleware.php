<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;

class ThrowableMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = new Response;

        try {
            return $handler->handle($request);
        } catch (\Throwable $ex) {
            $response = $response->withStatus(500);
            $response->getBody()->write($ex->getMessage());
            $output = $ex;
        }

        if ($output instanceof NotFound) {
            $response = $response->withStatus(404);
        }

        if ($output instanceof Forbidden) {
            $response = $response->withStatus(403);
        }

        return $response;
    }

}
