<?php

declare(strict_types=1);

namespace SetCMS\Application\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class MiddlewareParseBody implements MiddlewareInterface
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $contentType = $request->getHeaderLine('Content-type') ?? '';
        $content = $request->getBody()->getContents();

        if (str_contains($contentType, 'application/json') && $content) {
            $request = $request->withParsedBody(json_decode($content, true, 512, JSON_THROW_ON_ERROR));
        }

        return $handler->handle($request);
    }

}
