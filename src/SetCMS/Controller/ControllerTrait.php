<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\FactoryInterface;
use SetCMS\Scope;
use SetCMS\ServantInterface;
use SetCMS\Servant\ServeScopeServant;
use SetCMS\Controller\Event\ScopeProtectionEvent;

trait ControllerTrait
{

    private ContainerInterface $container;
    private FactoryInterface $factory;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->factory = $container->get(FactoryInterface::class);
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
    }

    private function protectScopeByRequest(Scope $scope, ServerRequestInterface $request): void
    {
        (new ScopeProtectionEvent($scope, $request))->dispatch($this->eventDispatcher);
    }

    private function serve(ServantInterface $servant, Scope $scope, array $array): Scope
    {
        $serveScope = ServeScopeServant::factory($this->factory);
        $serveScope->servent = $servant;
        $serveScope->scope = $scope;
        $serveScope->array = $array;
        $serveScope->serve();

        return $serveScope->scope;
    }

    private function protectedServe(ServerRequestInterface $request, ServantInterface $servant, Scope $scope, array $array): Scope
    {
        $this->protectScopeByRequest($scope, $request);

        return $this->serve($servant, $scope, $array);
    }

}
