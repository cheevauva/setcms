<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\RequestAttribute;

trait ControllerTrait
{

    use \SetCMS\QuickTrait;

    private function secureByScope(Scope $scope, ServerRequestInterface $request): void
    {
        $event = new ScopeProtectionHook;
        $event->scope = $scope;
        $event->user = RequestAttribute::currentUser->fromRequest($request);
        $event->dispatch();
    }

    protected function setupScope(Scope $scope): void
    {
        $hydrator = CorePropertyHydrateSevant::make($this->factory());
        $satisfyer = CorePropertySatisfyServant::make($this->factory());

        $this->directServe($scope, $hydrator);
        $this->directServe($scope, $satisfyer);
    }

    protected function directServe(Scope $scope, Servant $servant): void
    {
        $scope->to($servant);
        $servant->serve();
        $scope->from($servant);
    }

    private function serve(ServerRequestInterface $request, Servant $servant, Scope $scope): Scope
    {
        $scope->from($request);

        $this->secureByScope($scope, $request);
        $this->setupScope($scope);
        $this->directServe($scope, $servant);

        return $scope;
    }

    private function multiserve(ServerRequestInterface $request, array $servants, Scope $scope): Scope
    {
        $scope->from($request);
        $this->setupScope($scope);

        foreach ($servants as $servant) {
            $this->directServe($scope, $servant);

            if ($scope->hasMessages()) {
                return $scope;
            }
        }

        return $scope;
    }

}
