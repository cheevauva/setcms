<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Module01\DAO\Entity01RetrieveManyDAO;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;
use SetCMS\Module\Module01\Scope\Module01PrivateReadScope;
use SetCMS\Module\Module01\Scope\Module01PrivateEditScope;
use SetCMS\Module\Module01\Scope\Module01PrivateIndexScope;
use SetCMS\Module\Module01\Scope\Module01PrivateCreateScope;
use SetCMS\Module\Module01\Scope\Module01PrivateUpdateScope;
use SetCMS\Module\Module01\Servant\Entity01CreateServant;
use SetCMS\Module\Module01\Servant\Entity01UpdateServant;

class Module01PrivateController
{

    
    

    #[RequestMethod('GET')]
    public function index(Module01PrivateIndexScope $scope, Entity01RetrieveManyDAO $servant): Module01PrivateIndexScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    #[RequestMethod('GET')]
    public function read(Module01PrivateReadScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateReadScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    #[RequestMethod('GET')]
    public function new(Module01PrivateEditScope $scope): Module01PrivateEditScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function edit(Module01PrivateEditScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateEditScope
    {
        $this->serve($servant, $scope);
        
        return $scope;
    }

    #[RequestMethod('POST')]
    public function create(Module01PrivateCreateScope $scope): Module01PrivateCreateScope
    {
        $this->multiserve([
            Entity01CreateServant::new($this->container),
        ], $scope);
        
        return $scope;
    }

    #[RequestMethod('POST')]
    public function update(Module01PrivateUpdateScope $scope): Module01PrivateUpdateScope
    {
        $this->multiserve([
            Entity01RetrieveByIdDAO::new($this->container),
            Entity01UpdateServant::new($this->container),
        ], $scope);
        
        return $scope;
    }
}
