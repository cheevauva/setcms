<?php

declare(strict_types=1);

namespace SetCMS\Middleware\Servant;

use UUA\Servant;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareDispatcherServant extends Servant implements RequestHandlerInterface
{

    /**
     * @var string[]
     */
    public array $middlewares = [];
    protected int $index = -1;
    public ResponseInterface $response;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $this->middlewares = array_values($this->middlewares);
        $this->response = $this->handle($this->request);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->index++;

        if (empty($this->middlewares[$this->index])) {
            return $this->response;
        }

        return $this->createMiddleware($this->middlewares[$this->index])->process($request, $this);
    }

    private function createMiddleware(string $class): MiddlewareInterface
    {
        return $class::new($this->container);
    }
}
