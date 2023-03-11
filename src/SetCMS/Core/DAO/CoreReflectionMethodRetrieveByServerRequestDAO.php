<?php

declare(strict_types=1);

namespace SetCMS\Core\DAO;

use SetCMS\Contract\Servant;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Router\Router;
use ReflectionMethod;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByMethodNameDAO;
use SplObjectStorage;

class CoreReflectionMethodRetrieveByServerRequestDAO implements Servant
{

    use \SetCMS\FactoryTrait;
    use \SetCMS\DITrait;

    public ServerRequestInterface $request;
    public ?ResponseInterface $response = null;
    public ?ReflectionMethod $reflectionMethod;
    public ?object $reflectionObject;
    public ?array $reflectionArguments;

    public function serve(): void
    {
        $request = $this->request;

        $routerMatch = Router::make($this->container)->match(...[
            $request->getUri()->getPath(),
            $request->getMethod()
        ]);

        foreach ($routerMatch->params as $pName => $pValue) {
            $request = $request->withAttribute($pName, $pValue);
        }

        list($className, $methodName) = explode('::', $routerMatch->target);

        $retrieveMethod = CoreReflectionMethodRetrieveByMethodNameDAO::make($this->factory());
        $retrieveMethod->className = $className;
        $retrieveMethod->methodName = $methodName;
        $retrieveMethod->context = $this->getContext($request);
        $retrieveMethod->serve();

        $this->reflectionMethod = $retrieveMethod->reflectionMethod;
        $this->reflectionObject = $retrieveMethod->reflectionObject;
        $this->reflectionArguments = $retrieveMethod->reflectionArguments;
    }

    private function getContext(ServerRequestInterface $request): SplObjectStorage
    {
        $context = new SplObjectStorage;
        $context->attach($request, ServerRequestInterface::class);

        if (!empty($this->response)) {
            $context->attach($this->response, ResponseInterface::class);
        }

        return $context;
    }

}
