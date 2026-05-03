<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\View\ViewInternalServerError;
use SetCMS\Event\AppErrorEvent;

class MiddlewareExceptionHandler implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\EventDispatcherTrait;

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $exceptionHandlers = $this->container->get('exceptionHandlers');

            if (!is_array($exceptionHandlers)) {
                throw new \Exception('exceptionHandlers должен быть массивом');
            }

            return $handler->handle($request);
        } catch (\Throwable $ex) {
            $exceptionHandlers ??= [];

            if (!empty($exceptionHandlers[$ex::class])) {
                $view = ($exceptionHandlers[$ex::class])::new($this->container);
                $view->ex = $ex;
                $view->serve();
            } else {
                (new AppErrorEvent($ex->getMessage(), [
                    __METHOD__,
                    $ex->getFile(),
                    $ex->getLine(),
                ]))->dispatch($this->eventDispatcher());

                $view = ViewInternalServerError::new($this->container);
                $view->ex = $ex;
                $view->serve();
            }

            return $view->response;
        }
    }
}
