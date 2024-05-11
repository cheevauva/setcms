<?php

declare(strict_types=1);

namespace SetCMS\Core\Servant;

use Psr\Http\{
    Message\ServerRequestInterface,
    Message\ResponseInterface,
    Server\MiddlewareInterface,
    Server\RequestHandlerInterface
};

class CoreMiddlewareDispatcherServant implements RequestHandlerInterface
{

    use \SetCMS\QuickTrait;

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
        return $this->factory()->make($class);
    }

}
