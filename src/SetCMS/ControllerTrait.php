<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\Servant\ServeScopeServant;
use SetCMS\Controller\Event\ScopeProtectionEvent;
use SetCMS\RequestAttribute;

trait ControllerTrait
{

    use \SetCMS\QuickTrait;

    private function secureByScope(Scope $scope, ServerRequestInterface $request): void
    {
        $event = new ScopeProtectionEvent;
        $event->scope = $scope;
        $event->user = RequestAttribute::currentUser->fromRequest($request);
        $event->dispatch();
    }

    private function directServe(Servant $servant, Scope $scope, array $array): Scope
    {
        $serveScope = ServeScopeServant::make($this->factory());
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
