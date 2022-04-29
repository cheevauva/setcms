<?php

namespace SetCMS\FrontController;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\EventDispatcher;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Servant\BuildResponseByMixedValueServant;
use SetCMS\Servant\BuildMixedValueByRequestServant;
use SetCMS\Core\ServantInterface;

class FrontControllerServant implements ServantInterface
{

    protected ContainerInterface $container;
    protected EventDispatcher $eventDispatcher;
    public ServerRequestInterface $request;
    public ResponseInterface $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->eventDispatcher = $container->get(EventDispatcher::class);
    }

    public function serve(): void
    {
        try {
            $parseBody = new ParseBodyRequestServant;
            $parseBody->request = $this->request;
            $parseBody->serve();

            $buildMixedValue = new BuildMixedValueByRequestServant($this->container);
            $buildMixedValue->request = $parseBody->request;
            $buildMixedValue->response = $this->response;
            $buildMixedValue->serve();

            $output = $buildMixedValue->mixedValue;
        } catch (\Throwable $ex) {
            $output = $ex;
        }

        $prepareResponse = new BuildResponseByMixedValueServant($this->container);
        $prepareResponse->request = $parseBody->request;
        $prepareResponse->mixedValue = $output;
        $prepareResponse->serve();

        $this->response = $prepareResponse->response;
    }

}
