<?php

declare(strict_types=1);

namespace SetCMS\Core\DAO;

use SetCMS\Contract\Servant;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
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
        
        if (empty($this->response)) {
            $this->response = new Response;
        }
        
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
        $retrieveMethod->context = $this->getContext($request, $this->response);
        $retrieveMethod->serve();

        $this->reflectionMethod = $retrieveMethod->reflectionMethod;
        $this->reflectionObject = $retrieveMethod->reflectionObject;
        $this->reflectionArguments = $retrieveMethod->reflectionArguments;
    }

    private function getContext(ServerRequestInterface $request, ResponseInterface $response): SplObjectStorage
    {
        $context = new SplObjectStorage;
        $context->attach($request, ServerRequestInterface::class);
        $context->attach($response, ResponseInterface::class);

        return $context;
    }

}
