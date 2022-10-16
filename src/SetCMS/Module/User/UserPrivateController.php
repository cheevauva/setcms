<?php

declare(strict_types=1);

namespace SetCMS\Module\User;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveManyDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\Servant\UserEntitySaveServant;
use SetCMS\Module\User\Scope\UserPrivateEditScope;
use SetCMS\Module\User\Scope\UserPrivateIndexScope;
use SetCMS\Module\User\Scope\UserPrivateSaveScope;
use SetCMS\Module\User\Scope\UserPrivateReadScope;

class UserPrivateController
{

    use \SetCMS\Controller\ControllerTrait;

    public function index(ServerRequestInterface $request, UserPrivateIndexScope $scope, UserEntityDbRetrieveManyDAO $servant): UserPrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, UserPrivateReadScope $scope, UserEntityDbRetrieveByIdDAO $servant): UserPrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(ServerRequestInterface $request, UserPrivateEditScope $scope): UserPrivateEditScope
    {
        $this->protectScopeByRequest($scope, $request);
        
        return $scope;
    }

    public function edit(ServerRequestInterface $request, UserPrivateEditScope $scope, UserEntityDbRetrieveByIdDAO $servant): UserPrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, UserPrivateSaveScope $scope, UserEntitySaveServant $servant): UserPrivateSaveScope
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

}
