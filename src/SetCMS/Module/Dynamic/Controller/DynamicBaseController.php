<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Scope;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Application\Router\Exception\RouterNotAllowRequestMethodException;
use SetCMS\Application\Router\Exception\RouterMethodRequestNotDefinedException;
use SetCMS\Module\Dynamic\DAO\DynamicMethodRetrieveByMethodNameDAO;

abstract class DynamicBaseController
{

    use \SetCMS\Traits\RouterTrait;
    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\EventDispatcherTrait;
    use \SetCMS\Traits\EnvTrait;

    abstract protected function classNamePattern();

    public function action(ServerRequestInterface $request, ResponseInterface $response)
    {
        $context = new \SplObjectStorage;
        $context->attach($request, ServerRequestInterface::class);
        $context->attach($response, ResponseInterface::class);

        $retrieveMethod = DynamicMethodRetrieveByMethodNameDAO::make($this->factory());
        $retrieveMethod->context = $context;
        $retrieveMethod->methodName = $request->getAttribute('action');
        $retrieveMethod->className = strtr($this->classNamePattern(), [
            '{module}' => ucfirst($request->getAttribute('module')),
        ]);
        $retrieveMethod->serve();

        if ($retrieveMethod->reflectionMethod->getName() === __FUNCTION__ && is_a($retrieveMethod->className, __CLASS__, true)) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        $allowRequestMethods = null;

        foreach ($retrieveMethod->reflectionMethod->getAttributes() as $reflectionAttribute) {
            if (is_a($reflectionAttribute->getName(), RequestMethod::class, true)) {
                $allowRequestMethods = $reflectionAttribute->getArguments();
            }
        }

        if (empty($allowRequestMethods)) {
            throw new RouterMethodRequestNotDefinedException;
        }

        if (!in_array($request->getMethod(), $allowRequestMethods, true)) {
            throw new RouterNotAllowRequestMethodException;
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
