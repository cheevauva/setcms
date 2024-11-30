<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Contract\NotFound;
use SetCMS\Contract\Forbidden;
use SetCMS\Contract\NotAllow;

class MiddlewareThrowable implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = new Response;

        try {
            return $handler->handle($request);
        } catch (\Throwable $ex) {
            $response = $response->withStatus(500);

            if ($ex instanceof NotAllow) {
                $response = $response->withStatus(405);
            }
            if ($ex instanceof NotFound) {
                $response = $response->withStatus(404);
            }

            if ($ex instanceof Forbidden) {
                $response = $response->withStatus(403);
            }

            $response->getBody()->write($ex->getMessage());

            return $response;
        }
    }

}
