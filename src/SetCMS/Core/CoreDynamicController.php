<?php

declare(strict_types=1);

namespace SetCMS\Core;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByMethodNameDAO;
use SetCMS\Scope;
use SetCMS\Controller\Hook\ScopeProtectionHook;

abstract class CoreDynamicController
{

    use \SetCMS\Router\RouterTrait;
    use \SetCMS\DITrait;
    use \SetCMS\EventDispatcherTrait;

    abstract protected function classNamePattern();

    public function dynamicAction(ServerRequestInterface $request, ResponseInterface $response)
    {
        $context = new \SplObjectStorage;
        $context->attach($request, ServerRequestInterface::class);
        $context->attach($response, ResponseInterface::class);

        $retrieveMethod = CoreReflectionMethodRetrieveByMethodNameDAO::make($this->factory());
        $retrieveMethod->context = $context;
        $retrieveMethod->methodName = $request->getAttribute('action');
        $retrieveMethod->className = strtr($this->classNamePattern(), [
            '{module}' => ucfirst($request->getAttribute('module')),
        ]);
        $retrieveMethod->serve();

        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[1] ?? null;

        if ($caller && $caller['class'] === get_class($retrieveMethod->reflectionObject) && $caller['function'] === $this->action) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        foreach ($retrieveMethod->reflectionArguments as $argument) {
            if ($argument instanceof Scope) {
                $argument->from($request);

                $event = new ScopeProtectionHook;
                $event->scope = $argument;
                $event->user = $request->getAttribute('currentUser');
                $event->dispatch($this->eventDispatcher());
            }
        }

        return $retrieveMethod->reflectionMethod->invokeArgs($retrieveMethod->reflectionObject, $retrieveMethod->reflectionArguments);
    }

}
