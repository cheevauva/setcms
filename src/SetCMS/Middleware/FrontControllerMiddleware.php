<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Scope;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use SetCMS\Controller\Hook\ScopeProtectionHook;

class FrontControllerMiddleware implements MiddlewareInterface
{

    use \SetCMS\QuickTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $retrieveMethod = CoreReflectionMethodRetrieveByServerRequestDAO::make($this->factory());
        $retrieveMethod->response = new Response;
        $retrieveMethod->request = $request;
        $retrieveMethod->serve();

        foreach ($retrieveMethod->reflectionArguments as $argument) {
            if ($argument instanceof Scope) {
                $argument->from($request);

                $event = new ScopeProtectionHook;
                $event->scope = $argument;
                $event->user = $request->getAttribute('currentUser');
                $event->dispatch($this->eventDispatcher());
            }
        }

        $request = $request->withAttribute('output', $retrieveMethod->reflectionMethod->invokeArgs($retrieveMethod->reflectionObject, $retrieveMethod->reflectionArguments));

        return $handler->handle($request);
    }

}
