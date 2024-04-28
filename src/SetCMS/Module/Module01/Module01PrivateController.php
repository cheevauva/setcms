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

    public function index(ServerRequestInterface $request, Module01PrivateIndexScope $scope, Entity01RetrieveManyDAO $servant): Module01PrivateIndexScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function read(ServerRequestInterface $request, Module01PrivateReadScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateReadScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function new(ServerRequestInterface $request, Module01PrivateEditScope $scope): Module01PrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, Module01PrivateEditScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateEditScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function create(ServerRequestInterface $request, Module01PrivateCreateScope $scope): Module01PrivateCreateScope
    {
        return $this->multiserve($request, [
            Entity01SaveDAO::make($this->factory()),
        ], $scope);
    }

    public function update(ServerRequestInterface $request, Module01PrivateUpdateScope $scope): Module01PrivateUpdateScope
    {
        return $this->multiserve($request, [
            Entity01RetrieveByIdDAO::make($this->factory()),
            Entity01SaveDAO::make($this->factory())
        ], $scope);
    }

}
