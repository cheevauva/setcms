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

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;

    #[RequestMethod('GET')]
    public function index(Module01PrivateIndexScope $scope, Entity01RetrieveManyDAO $servant): Module01PrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function read(Module01PrivateReadScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function new(Module01PrivateEditScope $scope): Module01PrivateEditScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function edit(Module01PrivateEditScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function create(Module01PrivateCreateScope $scope): Module01PrivateCreateScope
    {
        return $this->multiserve([
            Entity01CreateServant::make($this->factory()),
        ], $scope);
    }

    #[RequestMethod('POST')]
    public function update(Module01PrivateUpdateScope $scope): Module01PrivateUpdateScope
    {
        return $this->multiserve([
            Entity01RetrieveByIdDAO::make($this->factory()),
            Entity01UpdateServant::make($this->factory()),
        ], $scope);
    }
}
