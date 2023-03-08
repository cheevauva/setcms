<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Contract\Factory;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\Servant\ServeScopeServant;
use SetCMS\Controller\Event\ScopeProtectionEvent;

trait ControllerTrait
{

    private ContainerInterface $container;
    private Factory $factory;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->factory = $container->get(Factory::class);
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
    }

    private function secureByScope(Scope $scope, ServerRequestInterface $request): void
    {
        (new ScopeProtectionEvent($scope, $request))->dispatch($this->eventDispatcher);
    }

    private function directServe(Servant $servant, Scope $scope, array $array): Scope
    {
        $serveScope = ServeScopeServant::make($this->factory);
        $serveScope->servent = $servant;
        $serveScope->scope = $scope;
        $serveScope->array = $array;
        $serveScope->serve();

        return $serveScope->scope;
    }

    private function serve(ServerRequestInterface $request, Servant $servant, Scope $scope, array $array = []): Scope
    {
        $this->secureByScope($scope, $request);
        $this->directServe($servant, $scope, $array);
        
        return $scope;
    }

    private function multiserve(ServerRequestInterface $request, array $servants, Scope $scope, array $array): Scope
    {
        foreach ($servants as $servant) {
            $this->serve($request, $servant, $scope, $array);

            if (!empty($scope->messages)) {
                return $scope;
            }
        }

        return $scope;
    }

}
