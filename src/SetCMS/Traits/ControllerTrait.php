<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SetCMS\Scope;
use SetCMS\Application\Contract\ContractServant;
use SetCMS\Core\Servant\CorePropertySatisfyServant;
use SetCMS\Core\Servant\CorePropertyHydrateServant;
use SetCMS\Core\Servant\CorePropertyFetchDataFromRequestServant;

trait ControllerTrait
{

    use \SetCMS\Traits\QuickTrait;

    protected function serveScope(Scope $scope): void
    {
        $this->multiserveServantWithScope([
            CorePropertyFetchDataFromRequestServant::class,
            CorePropertyHydrateServant::class,
            CorePropertySatisfyServant::class,
        ], $scope);
    }

    protected function serveServantWithScope(ContractServant $servant, Scope $scope): void
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

    private function serve(string|ContractServant $servant, Scope $scope): Scope
    {
        if (is_string($servant)) {
            $servant = $this->factory()->make($servant);
        }

        $this->serveScope($scope);

        if ($scope->hasMessages()) {
            return $scope;
        }

        $this->serveServantWithScope($servant, $scope);

        return $scope;
    }

    private function multiserve(array $servants, Scope $scope): Scope
    {
        $this->serveScope($scope);
        $this->multiserveServantWithScope($servants, $scope);

        return $scope;
    }

}
