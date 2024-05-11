<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Module01\DAO\Entity01RetrieveManyDAO;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;
use SetCMS\Module\Module01\Scope\Module01PrivateReadScope;
use SetCMS\Module\Module01\Scope\Module01PrivateEditScope;
use SetCMS\Module\Module01\Scope\Module01PrivateIndexScope;
use SetCMS\Module\Module01\Scope\Module01PrivateCreateScope;
use SetCMS\Module\Module01\Scope\Module01PrivateUpdateScope;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;

class Module01PrivateController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(Module01PrivateIndexScope $scope, Entity01RetrieveManyDAO $servant): Module01PrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    public function read(Module01PrivateReadScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    public function new(Module01PrivateEditScope $scope): Module01PrivateEditScope
    {
        return $scope;
    }

    public function edit(Module01PrivateEditScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    public function create(Module01PrivateCreateScope $scope): Module01PrivateCreateScope
    {
        return $this->multiserve([
            Entity01SaveDAO::make($this->factory()),
        ], $scope);
    }

    public function update(Module01PrivateUpdateScope $scope): Module01PrivateUpdateScope
    {
        return $this->multiserve([
            Entity01RetrieveByIdDAO::make($this->factory()),
            Entity01SaveDAO::make($this->factory())
        ], $scope);
    }

}
