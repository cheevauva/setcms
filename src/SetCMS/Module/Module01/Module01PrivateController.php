<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Module01\DAO\Entity01EntityRetrieveManyDAO;
use SetCMS\Module\Module01\DAO\Entity01EntityRetrieveByIdDAO;
use SetCMS\Module\Module01\Scope\Module01PrivateReadScope;
use SetCMS\Module\Module01\Scope\Module01PrivateEditScope;
use SetCMS\Module\Module01\Scope\Module01PrivateIndexScope;
use SetCMS\Module\Module01\Scope\Module01PrivateCreateScope;
use SetCMS\Module\Module01\Scope\Module01PrivateUpdateScope;
use SetCMS\Module\Module01\Servant\Entity01EntityCreateServant;
use SetCMS\Module\Module01\Servant\Entity01EntityUpdateServant;

class Module01PrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, Module01PrivateIndexScope $scope, Entity01EntityRetrieveManyDAO $servant): Module01PrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, Module01PrivateReadScope $scope, Entity01EntityRetrieveByIdDAO $servant): Module01PrivateReadScope
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

    public function edit(ServerRequestInterface $request, Module01PrivateEditScope $scope, Entity01EntityRetrieveByIdDAO $servant): Module01PrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function create(ServerRequestInterface $request, Module01PrivateCreateScope $scope, Entity01EntityCreateServant $servant): Module01PrivateCreateScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, Module01PrivateUpdateScope $scope, Entity01EntityUpdateServant $update, Entity01EntityRetrieveByIdDAO $readById): Module01PrivateUpdateScope
    {
        return $this->multiserve($request, [$readById, $update], $scope, $request->getParsedBody());
    }

}
