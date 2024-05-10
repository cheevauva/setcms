<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Core\Servant\CorePropertySatisfyServant;
use SetCMS\Core\Servant\CorePropertyHydrateServant;
use SetCMS\Core\Servant\CorePropertyFetchDataFromRequestServant;

trait ControllerTrait
{

    use \SetCMS\QuickTrait;

    private function secureByScope(Scope $scope, ServerRequestInterface $request): void
    {
        $event = new ScopeProtectionHook;
        $event->scope = $scope;
        $event->from($request);
        $event->dispatch($this->eventDispatcher());
    }

    protected function serveScope(Scope $scope): void
    {
        $this->multiserveServantWithScope([
            CorePropertyFetchDataFromRequestServant::make($this->factory()),
            CorePropertyHydrateServant::make($this->factory()),
            CorePropertySatisfyServant::make($this->factory()),
        ], $scope);
    }

    protected function serveServantWithScope(Servant $servant, Scope $scope): void
    {
        try {
            $scope->to($servant);
            $servant->serve();
            $scope->from($servant);
        } catch (\SetCMS\Exception $ex) {
            $scope->from($ex);
        }
    }

    protected function multiserveServantWithScope(array $servants, Scope $scope): void
    {
        if ($scope->hasMessages()) {
            return;
        }

        foreach ($servants as $servant) {
            if (is_string($servant)) {
                $servant = $this->factory()->make($servant);
            }

            $this->serveServantWithScope($servant, $scope);

            if ($scope->hasMessages()) {
                return;
            }
        }
    }

    private function serve(ServerRequestInterface $request, Servant $servant, Scope $scope): Scope
    {
        $scope->from($request);
        //
        $this->secureByScope($scope, $request);
        $this->serveScope($scope);

        if ($scope->hasMessages()) {
            return $scope;
        }

        $this->serveServantWithScope($servant, $scope);

        return $scope;
    }

    private function multiserve(ServerRequestInterface $request, array $servants, Scope $scope): Scope
    {
        $scope->from($request);
        //
        $this->serveScope($scope);
        $this->multiserveServantWithScope($servants, $scope);

        return $scope;
    }

}
