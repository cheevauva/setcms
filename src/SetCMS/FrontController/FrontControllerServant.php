<?php

namespace SetCMS\FrontController;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\FactoryInterface;
use SetCMS\Core\ServantInterface;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Servant\BuildResponseByMixedValueServant;
use SetCMS\Servant\BuildMixedValueByRequestServant;

class FrontControllerServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    private EventDispatcherInterface $eventDispatcher;
    private BuildMixedValueByRequestServant $buildMixedValue;
    private ParseBodyRequestServant $parseBody;
    private BuildResponseByMixedValueServant $prepareResponse;
    public ServerRequestInterface $request;
    public ResponseInterface $response;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
        $this->buildMixedValue = BuildMixedValueByRequestServant::factory($this->factory);
        $this->parseBody = ParseBodyRequestServant::factory($this->factory);
        $this->prepareResponse = BuildResponseByMixedValueServant::factory($this->factory);
    }

    public function serve(): void
    {
        try {
            $this->parseBody->request = $this->request;
            $this->parseBody->serve();

            $this->buildMixedValue->request = $this->parseBody->request;
            $this->buildMixedValue->response = $this->response;
            $this->buildMixedValue->serve();

            $output = $this->buildMixedValue->mixedValue;
        } catch (\Throwable $ex) {
            $output = $ex;
        }

        $this->prepareResponse->request = $this->parseBody->request;
        $this->prepareResponse->mixedValue = $output;
        $this->prepareResponse->serve();

        $this->response = $this->prepareResponse->response;
    }

}
