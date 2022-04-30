<?php

namespace SetCMS\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\FactoryInterface;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Servant\BuildResponseByMixedValueServant;
use SetCMS\Servant\BuildMixedValueByRequestServant;
use SetCMS\Servant\MatchRouteByRequestServant;
use SetCMS\Controller\Servant\BuildByTargetStringServant;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;

class FrontController
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    private EventDispatcherInterface $eventDispatcher;
    private BuildMixedValueByRequestServant $buildMixedValue;
    private ParseBodyRequestServant $parseBody;
    private BuildResponseByMixedValueServant $prepareResponse;
    private MatchRouteByRequestServant $matchRequest;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
        $this->buildMixedValue = BuildMixedValueByRequestServant::factory($this->factory);
        $this->parseBody = ParseBodyRequestServant::factory($this->factory);
        $this->prepareResponse = BuildResponseByMixedValueServant::factory($this->factory);
        $this->matchRequest = MatchRouteByRequestServant::factory($this->factory);
    }

    public function resolve(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $this->matchRequest->apply($request);
            $this->matchRequest->serve();
            
            $this->parseBody->request = $request;
            $this->parseBody->serve();

            $controllerBuilder = BuildByTargetStringServant::factory($this->factory);
            $controllerBuilder->target = $this->matchRequest->routerMatch->target;
            $controllerBuilder->serve();

            $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::factory($this->factory);
            $methodArgumentsBuilder->apply($controllerBuilder->method);
            $methodArgumentsBuilder->apply($this->parseBody->request);
            $methodArgumentsBuilder->apply($response);
            $methodArgumentsBuilder->serve();

            $output = $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);
        } catch (\Throwable $ex) {
            $output = $ex;
        }

        $this->prepareResponse->request = $this->parseBody->request;
        $this->prepareResponse->mixedValue = $output;
        $this->prepareResponse->serve();

        return $this->prepareResponse->response;
    }

}
