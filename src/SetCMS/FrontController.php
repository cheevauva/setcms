<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Module\Modules\ModuleException;
use SetCMS\EventDispatcher;
use SetCMS\FrontController\TargetForm;
use SetCMS\Servant\RetrieveArgumentsByReflectionMethodServant;
use SetCMS\Servant\BuildControllerWithReflectionMethodServant;
use SetCMS\Servant\MatchRequestRouterServant;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Servant\PrepareResponseByMixedValueServant;
use Throwable;

class FrontController
{

    protected ContainerInterface $container;
    protected ServerRequestInterface $request;
    protected EventDispatcher $eventDispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->eventDispatcher = $container->get(EventDispatcher::class);
    }

    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $parseBody = new ParseBodyRequestServant;
            $parseBody->request = $request;
            $parseBody->serve();

            $output = $this->process($parseBody->request, $response);
        } catch (Throwable $ex) {
            $output = $ex;
        }

        $prepareResponse = new PrepareResponseByMixedValueServant;
        $prepareResponse->mixedValue = $output;
        $prepareResponse->serve();

        return $prepareResponse->response;
    }

    protected function process(ServerRequestInterface $request, ResponseInterface $response): mixed
    {
        $matchRequest = new MatchRequestRouterServant($this->container);
        $matchRequest->request = $request;
        $matchRequest->serve();

        foreach ($matchRequest->result as $attribute => $attributeValue) {
            $request = $request->withAttribute($attribute, $attributeValue);
        }

        $targetForm = new TargetForm;
        $targetForm->fromArray($matchRequest->result);

        if (!$targetForm->isValid()) {
            throw ModuleException::notFound();
        }

        $controllerWithMethod = new BuildControllerWithReflectionMethodServant;
        $controllerWithMethod->apply($targetForm);
        $controllerWithMethod->serve();

        $methodArguments = new RetrieveArgumentsByReflectionMethodServant($this->container);
        $methodArguments->method = $controllerWithMethod->method;
        $methodArguments->request = $request;
        $methodArguments->response = $response;
        $methodArguments->serve();

        return $controllerWithMethod->method->invokeArgs($controllerWithMethod->controller, $methodArguments->arguments);
    }

}
