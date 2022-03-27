<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\EventDispatcher;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Servant\BuildResponseByMixedValueServant;
use Throwable;
use SetCMS\Servant\BuildMixedValueByRequestServant;

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

            $buildMixedValue = new BuildMixedValueByRequestServant($this->container);
            $buildMixedValue->request = $parseBody->request;
            $buildMixedValue->response = $response;
            $buildMixedValue->serve();

            $output = $buildMixedValue->mixedValue;
        } catch (Throwable $ex) {
            $output = $ex;
        }

        $prepareResponse = new BuildResponseByMixedValueServant($this->container);
        $prepareResponse->request = $request;
        $prepareResponse->mixedValue = $output;
        $prepareResponse->serve();

        return $prepareResponse->response;
    }

}
