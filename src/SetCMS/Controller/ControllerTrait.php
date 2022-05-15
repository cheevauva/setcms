<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use SetCMS\Scope;
use SetCMS\ServantInterface;
use SetCMS\Servant\ServeScopeServant;

trait ControllerTrait
{

    private function serve(ServantInterface $servant, Scope $scope, array $array = []): Scope
    {
        $serve = new ServeScopeServant;
        $serve->servent = $servant;
        $serve->scope = $scope;
        $serve->array = $array;
        $serve->serve();
        
        return $serve->scope;
    }
    
}
