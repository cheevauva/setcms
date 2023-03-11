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
use SetCMS\Module\Module01\Servant\Entity01CreateServant;
use SetCMS\Module\Module01\Servant\Entity01UpdateServant;

class Module01PrivateController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, Module01PrivateIndexScope $scope, Entity01RetrieveManyDAO $servant): Module01PrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, Module01PrivateReadScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(ServerRequestInterface $request, Module01PrivateEditScope $scope): Module01PrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, Module01PrivateEditScope $scope, Entity01RetrieveByIdDAO $servant): Module01PrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function create(ServerRequestInterface $request, Module01PrivateCreateScope $scope, Entity01CreateServant $servant): Module01PrivateCreateScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, Module01PrivateUpdateScope $scope, Entity01UpdateServant $update, Entity01RetrieveByIdDAO $readById): Module01PrivateUpdateScope
    {
        return $this->multiserve($request, [
            $readById,
            $update
        ], $scope, $request->getParsedBody());
    }

}
